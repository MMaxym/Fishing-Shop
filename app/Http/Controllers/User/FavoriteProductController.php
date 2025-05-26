<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FavoriteProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class FavoriteProductController extends Controller
{
    public function favoriteProducts(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('user.main')->with('error', 'Будь ласка, увійдіть в акаунт, щоб переглянути улюблені товари.');
        }

        $userId = Auth::id();

        $likedProductIds = FavoriteProduct::where('user_id', $userId)
            ->pluck('product_id')
            ->toArray();

        $products = Product::with('images', 'discount')
            ->where('is_active', 1)
            ->whereIn('id', $likedProductIds)
            ->get();

        $products = $this->addLikeInfoToProducts($products, $likedProductIds);
        $products = $this->addDiscountAndNewInfo($products);

        $recentlyViewed = session()->get('recently_viewed', []);
        $recentlyViewedProducts = Product::with('images')
            ->whereIn('id', $recentlyViewed)
            ->get()
            ->sortBy(function ($product) use ($recentlyViewed) {
                return array_search($product->id, $recentlyViewed);
            });

        $recentlyViewedProducts = $this->addLikeInfoToProducts($recentlyViewedProducts, $likedProductIds);
        $recentlyViewedProducts = $this->addDiscountAndNewInfo($recentlyViewedProducts);

        if ($request->ajax()) {
            $favoriteHtml = view('partials.favorite-products', compact('products'))->render();
            $recentlyHtml = view('partials.recently-products', compact('recentlyViewedProducts'))->render();

            return response()->json([
                'favorites' => $favoriteHtml,
                'recently' => $recentlyHtml,
            ]);
        }

        return view('user.favoriteProducts', compact('products', 'recentlyViewedProducts'));
    }

    private function addLikeInfoToProducts($products, $likedProductIds)
    {
        foreach ($products as $product) {
            $product->isLiked = in_array($product->id, $likedProductIds);
        }
        return $products;
    }

    private function addDiscountAndNewInfo($products)
    {
        $oneMonthAgo = Carbon::now()->subMonth();

        foreach ($products as $product) {
            $product->isDiscounted = !is_null($product->discount);
            $product->isNew = $product->created_at > $oneMonthAgo || $product->updated_at > $oneMonthAgo;
        }

        return $products;
    }

    public function toggle($productId)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Щоб додати товар в улюблені, спочатку увійдіть в акаунт!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        $favorite = FavoriteProduct::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($favorite) {
            $favorite->delete();

            return response()->json(['status' => 'removed']);
        }
        else {
            FavoriteProduct::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);

            return response()->json(['status' => 'added']);
        }
    }
}
