<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SaleProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('images', 'discount')
            ->where('is_active', 1)
            ->whereNotNull('discount_id')
            ->paginate(12);

        foreach ($products as $product) {
            $product->isDiscounted = true;
        }

        $currentPage = $products->currentPage();
        $perPage = $products->perPage();
        $totalItems = $products->total();
        $itemsShown = ($currentPage - 1) * $perPage + $products->count();

        return view('user.saleProducts', compact('products', 'currentPage', 'perPage', 'totalItems', 'itemsShown'));
    }

}
