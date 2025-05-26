<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FavoriteProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ShoppingCartController extends Controller
{
    public function index(){
        if (!Auth::check()) {
            return redirect()->route('user.main')->with('error', 'Будь ласка, увійдіть в акаунт, щоб перейти на сторінку кошику.');
        }

        $likedProductIds = [];

        if (Auth::check()) {
            $likedProductIds = FavoriteProduct::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
        }

        $recentlyViewed = session()->get('recently_viewed', []);
        $recentlyViewedProducts = Product::with('images')
            ->whereIn('id', $recentlyViewed)
            ->get()
            ->sortBy(function ($product) use ($recentlyViewed) {
                return array_search($product->id, $recentlyViewed);
            });

        $oneMonthAgo = \Carbon\Carbon::now()->subMonth();

        foreach ($recentlyViewedProducts as $item) {
            $item->isNew = $item->created_at > $oneMonthAgo || $item->updated_at > $oneMonthAgo;
            $item->isLiked = in_array($item->id, $likedProductIds);
        }

        return view('user.shoppingCart', compact('recentlyViewedProducts'));
    }
}
