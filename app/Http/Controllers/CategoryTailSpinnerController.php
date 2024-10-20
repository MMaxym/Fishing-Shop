<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoryTailSpinnerController extends Controller
{
    public function index(Request $request)
    {
        $oneMonthAgo = Carbon::now()->subMonth();

        $products = Product::with('images', 'discount')
            ->where('is_active', 1)
            ->whereHas('category', function ($query) {
                $query->where('name', 'Тейл-спінери');
            })
            ->paginate(12);


        foreach ($products as $product) {
            $product->isDiscounted = !is_null($product->discount);
            $product->isNew = $product->created_at > $oneMonthAgo || $product->updated_at > $oneMonthAgo;
        }

        $currentPage = $products->currentPage();
        $perPage = $products->perPage();
        $totalItems = $products->total();
        $itemsShown = ($currentPage - 1) * $perPage + $products->count();

        return view('user.categoryTailSpinners', compact('products', 'currentPage', 'perPage', 'totalItems', 'itemsShown'));
    }
}
