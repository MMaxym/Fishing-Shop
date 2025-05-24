<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FavoriteProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryBalancerController extends Controller
{
    public function index(Request $request)
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        $sortOrder = $request->get('sort', 'none');
        $minPrice = $request->get('min_price', null);
        $maxPrice = $request->get('max_price', null);

        $minPriceFromDB = Product::whereHas('category', function ($query) {
            $query->where('name', 'Балансири');
        })->min('actual_price');

        $maxPriceFromDB = Product::whereHas('category', function ($query) {
            $query->where('name', 'Балансири');
        })->max('actual_price');

        $products = Product::with('images', 'discount')
            ->where('is_active', 1)
            ->whereHas('category', function ($query) {
                $query->where('name', 'Балансири');
            });

        if ($minPrice !== null) {
            $products->where( 'actual_price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $products->where('actual_price', '<=', $maxPrice);
        }

        $likedProductIds = [];

        if (Auth::check()) {
            $likedProductIds = FavoriteProduct::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
        }

        $products = $this->applySorting($products, $sortOrder);
        $products = $products->paginate(12);

        foreach ($products as $product) {
            $product->isDiscounted = !is_null($product->discount);
            $product->isNew = $product->created_at > $oneMonthAgo || $product->updated_at > $oneMonthAgo;
            $product->isLiked = in_array($product->id, $likedProductIds);
        }

        $currentPage = $products->currentPage();
        $perPage = $products->perPage();
        $totalItems = $products->total();
        $itemsShown = ($currentPage - 1) * $perPage + $products->count();

        if ($request->ajax()) {
            return response()->view('partials.products', compact(
                'products', 'currentPage', 'perPage', 'totalItems', 'itemsShown',
                'sortOrder', 'minPrice', 'maxPrice', 'minPriceFromDB', 'maxPriceFromDB'
            ));
        }

        return view('user.categoryBalancers', compact(
            'products', 'currentPage', 'perPage', 'totalItems', 'itemsShown',
            'sortOrder', 'minPrice', 'maxPrice', 'minPriceFromDB', 'maxPriceFromDB'
        ));
    }

    private function applySorting($products, $sortOrder)
    {
        if ($sortOrder == 'low_to_high') {
            return $products->orderBy('actual_price', 'asc');
        }
        elseif ($sortOrder == 'high_to_low') {
            return $products->orderBy('actual_price', 'desc');
        }
        elseif ($sortOrder == 'a_to_z') {
            return $products->orderBy('name', 'asc');
        }
        elseif ($sortOrder == 'z_to_a') {
            return $products->orderBy('name', 'desc');
        }

        return $products;
    }
}
