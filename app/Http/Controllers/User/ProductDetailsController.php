<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FavoriteProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ProductDetailsController extends Controller
{
    public function showDetails($id)
    {
        $product = Product::with(['images', 'discount', 'category'])->findOrFail($id);

        $likedProductIds = [];
        if (Auth::check()) {
            $likedProductIds = FavoriteProduct::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
        }

        $recentlyViewed = session()->get('recently_viewed', []);
        $recentlyViewed = array_filter($recentlyViewed, fn($viewedId) => $viewedId != $id);
        array_unshift($recentlyViewed, $id);
        $recentlyViewed = array_slice($recentlyViewed, 0, 8);
        session(['recently_viewed' => $recentlyViewed]);

        $recentlyViewedProducts = Product::with('images')
            ->whereIn('id', $recentlyViewed)
            ->where('id', '!=', $id)
            ->get()
            ->sortBy(function ($product) use ($recentlyViewed) {
                return array_search($product->id, $recentlyViewed);
            });

        $oneMonthAgo = \Carbon\Carbon::now()->subMonth();

        foreach ($recentlyViewedProducts as $item) {
            $item->isNew = $item->created_at > $oneMonthAgo || $item->updated_at > $oneMonthAgo;
            $item->isLiked = in_array($item->id, $likedProductIds);
        }

        $product->isNew = $product->created_at > $oneMonthAgo || $product->updated_at > $oneMonthAgo;
        $product->isLiked = in_array($product->id, $likedProductIds);

        return view('user.productDetails', compact('product', 'recentlyViewedProducts'));
    }
}
