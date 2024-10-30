<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleProductController extends Controller
{
    public function index(Request $request)
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        $sortOrder = $request->get('sort', 'none');
        $category = $request->get('category', 'none');
        $minPrice = $request->get('min_price', null);
        $maxPrice = $request->get('max_price', null);

        $minPriceFromDB = Product::where('is_active', 1)
            ->whereNotNull('discount_id')
            ->min('actual_price');

        $maxPriceFromDB = Product::where('is_active', 1)
            ->whereNotNull('discount_id')
            ->max('actual_price');

        $products = Product::with('images', 'discount', 'category')
        ->where('is_active', 1)
            ->whereNotNull('discount_id');

        if ($minPrice !== null) {
            $products->where('actual_price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $products->where('actual_price', '<=', $maxPrice);
        }

        if ($category !== 'none') {
            $products->where('category_id', $category);
        }

        $products = $this->applySorting($products, $sortOrder);

        $products = $products->paginate(12);

        foreach ($products as $product) {
            $product->isDiscounted = !is_null($product->discount);
            $product->isNew = $product->created_at > $oneMonthAgo || $product->updated_at > $oneMonthAgo;
            $product->actual_price = $product->discountedPrice();
        }

        $currentPage = $products->currentPage();
        $perPage = $products->perPage();
        $totalItems = $products->total();
        $itemsShown = ($currentPage - 1) * $perPage + $products->count();

        return view('user.saleProducts', compact(
            'products', 'currentPage', 'perPage', 'totalItems', 'itemsShown',
            'sortOrder', 'category', 'minPrice', 'maxPrice', 'minPriceFromDB', 'maxPriceFromDB'
        ));
    }

    private function applySorting($products, $sortOrder)
    {
        if ($sortOrder == 'low_to_high') {
            return $products->orderBy('actual_price', 'asc');
        } elseif ($sortOrder == 'high_to_low') {
            return $products->orderBy('actual_price', 'desc');
        } elseif ($sortOrder == 'a_to_z') {
            return $products->orderBy('name', 'asc');
        } elseif ($sortOrder == 'z_to_a') {
            return $products->orderBy('name', 'desc');
        }

        return $products;
    }
}
