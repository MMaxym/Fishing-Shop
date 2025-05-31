<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('user.main')->with('error', 'Будь ласка, увійдіть в акаунт, щоб перейти на сторінку адміністратора.');
        }

        $categories = Category::all();
        $products = Product::all();
        return view('admin.products.index', compact('products', 'categories'));
    }


    public function create()
    {
        $categories = Category::all();
        $discounts = Discount::all();
        return view('admin.products.create', compact('categories', 'discounts'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'discount_id' => 'nullable|exists:discounts,id',
            'article' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'size' => 'required|string|max:100',
            'other' => 'required|string|max:150',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Product::create($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Товар створено успішно !!!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $discounts = Discount::all();
        return view('admin.products.edit', compact('product', 'categories', 'discounts'));
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'discount_id' => 'nullable|exists:discounts,id',
            'article' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'size' => 'required|string|max:100',
            'other' => 'required|string|max:150',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product->is_active = $request->has('is_active') ? 1 : 0;
        $product->update($request->except('is_active'));
        $product->save();
        return redirect()->route('admin.products.index')->with('success', 'Товар оновлено успішно !!!');
    }


    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('error', 'Товар успішно видалено !!!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'like', '%' . $query . '%')
            ->with('category', 'discount')
            ->get();

        return response()->json(['products' => $products]);
    }

    public function filter(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');
        $status = $request->input('status');
        $quantity = $request->input('quantity');

        $products = Product::query();

        if ($query) {
            $products->where('name', 'like', '%' . $query . '%');
        }

        if ($category) {
            $products->where('category_id', $category);
        }

        if ($priceMin) {
            $products->where('price', '>=', $priceMin);
        }

        if ($priceMax) {
            $products->where('price', '<=', $priceMax);
        }

        if ($status) {
            $products->where('is_active', $status === 'active');
        }

        if ($quantity !== null) {
            $products->where('quantity', '<=', $quantity);
        }

        return response()->json([
            'products' => $products->with('category', 'discount')->get()
        ]);
    }
    public function export(Request $request)
    {
        $filteredProducts = Product::query();

        if ($request->filled('query')) {
            $filteredProducts->where('name', 'like', '%' . $request->input('query') . '%');
        }

        if ($request->filled('category')) {
            $filteredProducts->where('category_id', $request->input('category'));
        }

        if ($request->filled('price_min')) {
            $filteredProducts->where('price', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $filteredProducts->where('price', '<=', $request->input('price_max'));
        }

        if ($request->filled('status')) {
            $filteredProducts->where('is_active', $request->input('status') === 'active');
        }

        if ($request->filled('quantity')) {
            $filteredProducts->where('quantity', '>=', $request->input('quantity'));
        }

        $products = $filteredProducts->get(['article', 'name', 'category_id', 'description', 'size', 'other', 'quantity', 'price', 'discount_id', 'is_active']);

        return Excel::download(new ProductsExport($products), 'products_report_' . now()->addHours(3)->format('Y-m-d_H:i:s') . '.xlsx');
    }

    public function pdfExport(Request $request)
    {
        $filteredProducts = Product::query();

        if ($request->filled('query')) {
            $filteredProducts->where('name', 'like', '%' . $request->input('query') . '%');
        }

        if ($request->filled('category')) {
            $filteredProducts->where('category_id', $request->input('category'));
        }

        if ($request->filled('price_min')) {
            $filteredProducts->where('price', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $filteredProducts->where('price', '<=', $request->input('price_max'));
        }

        if ($request->filled('status')) {
            $filteredProducts->where('is_active', $request->input('status') === 'active');
        }

        if ($request->filled('quantity')) {
            $filteredProducts->where('quantity', '>=', $request->input('quantity'));
        }

        $products = $filteredProducts->get(['article', 'name', 'category_id', 'description', 'size', 'other', 'quantity', 'price', 'discount_id', 'is_active']);

        $pdf = PDF::loadView('admin.products.export.pdf.invoice', compact('products'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('products_report_' . now()->addHours(3)->format('Y-m-d_H:i:s') . '.pdf');
    }

}
