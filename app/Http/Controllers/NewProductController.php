<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewProductController extends Controller
{
    public function index(Request $request)
    {
        $oneMonthAgo = Carbon::now()->subMonth();

        $products = Product::with('images', 'discount')
            ->where('is_active', 1)
            ->where(function ($query) use ($oneMonthAgo) {
                $query->where('created_at', '>', $oneMonthAgo)
                    ->orWhere('updated_at', '>', $oneMonthAgo);
            })
            ->paginate(12);

        foreach ($products as $product) {
            $product->isNew = true;
        }

        $currentPage = $products->currentPage();
        $perPage = $products->perPage();
        $totalItems = $products->total();
        $itemsShown = ($currentPage - 1) * $perPage + $products->count();

        return view('user.newProducts', compact('products', 'currentPage', 'perPage', 'totalItems', 'itemsShown'));
    }

}
