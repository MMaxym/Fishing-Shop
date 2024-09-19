<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
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

        return redirect()->route('admin.products.index')->with('success', 'Продукт створено успішно !!!');
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
        return redirect()->route('admin.products.index')->with('success', 'Продукт оновлено успішно !!!');
    }


    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('error', 'Продукт успішно видалено !!!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'like', '%' . $query . '%')
            ->with('category', 'discount')
            ->get();

        return response()->json(['products' => $products]);
    }

}
