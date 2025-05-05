<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'unauthorized'], 401);
        }

        $productInput = $request->input('product');

        $productInDb = Product::find($productInput['id']);

        if (!$productInDb) {
            return response()->json(['message' => 'Товар не знайдено.'], 404);
        }

        if ($productInDb->quantity <= 0) {
            return response()->json(['message' => 'Товару немає в наявності.'], 400);
        }

        if ($productInput['quantity'] > $productInDb->quantity) {
            return response()->json([
                'message' => 'Вказана кількість товару перевищує доступну. <br> В наявності: ' . $productInDb->quantity . ' шт.'
            ], 400);
        }

        $cart = session()->get('cart', []);

        $existingIndex = collect($cart)->search(function ($item) use ($productInput) {
            return $item['id'] == $productInput['id'] && $item['size'] == $productInput['size'];
        });

        if ($existingIndex !== false) {
            $newQty = $cart[$existingIndex]['quantity'] + $productInput['quantity'];

            if ($newQty > $productInDb->quantity) {
                return response()->json([
                    'message' => 'Загальна кількість товару в кошику перевищує наявну. В наявності: ' . $productInDb->quantity
                ], 400);
            }

            $cart[$existingIndex]['quantity'] = $newQty;

            session(['cart' => $cart]);

            return response()->json([
                'message' => 'updated',
                'addedQuantity' => $productInput['quantity'],
                'cartCount' => count($cart)
            ]);
        }
        else {
            $cart[] = $productInput;

            session(['cart' => $cart]);

            return response()->json([
                'message' => 'added',
                'cartCount' => count($cart)
            ]);
        }
    }

    public function updateQuantity(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = (int) $request->input('id');
        $newQty = (int) $request->input('quantity');

        $productInDb = Product::find($id);

        if (!$productInDb) {
            return response()->json(['message' => 'Товар не знайдено.'], 404);
        }

        if ($productInDb->quantity <= 0) {
            return response()->json(['message' => 'Товару немає в наявності.'], 400);
        }

        if ($newQty > $productInDb->quantity) {
            return response()->json([
                'message' => 'Вказана кількість товару перевищує доступну. <br> В наявності: ' . $productInDb->quantity . ' шт.'
            ], 400);
        }

        foreach ($cart as $key => $item) {
            if ((int)$item['id'] === $id) {
                $cart[$key]['quantity'] = $newQty;
                session()->put('cart', $cart);
                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false]);
    }

    public function remove($id, Request $request)
    {
        $cart = session()->get('cart', []);

        $cart = array_filter($cart, function ($item) use ($id) {
            return $item['id'] != $id;
        });

        $cart = array_values($cart);

        session()->put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'message' => 'Товар видалено з кошика',
            'cart' => $cart
        ]);
    }
}
