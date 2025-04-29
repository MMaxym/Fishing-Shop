<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FavoriteProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class FavoriteProductController extends Controller
{
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
