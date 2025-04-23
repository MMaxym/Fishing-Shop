<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Support\Carbon;

class MainUserController extends Controller
{
    public function index()
    {
        $products = $this->showNewProducts();
        $products2 = $this->showDiscountProducts();
        return view('user.main', compact('products', 'products2'));
    }

    public function showAbout()
    {
        return view('user.about');
    }

    public function showDiscount()
    {
        $currentDate = Carbon::now();

        $productDiscounts = Discount::where('type', 'На товар')
            ->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->get();

        $orderDiscounts = Discount::where('type', 'На замовлення')
            ->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->get();

        return view('user.discount', compact('productDiscounts', 'orderDiscounts'));
    }

    public function showDelivery()
    {
        return view('user.delivery');
    }

    public function showNewProducts()
    {
        $oneMonthAgo = \Carbon\Carbon::now()->subMonth();

        $products = Product::with('images', 'discount', 'category')
            ->where('is_active', 1)
            ->where('quantity', '>', 0)
            ->where(function ($query) use ($oneMonthAgo) {
                $query->where('created_at', '>', $oneMonthAgo)
                    ->orWhere('updated_at', '>', $oneMonthAgo);
            })
            ->orderBy('updated_at', 'desc')
            ->limit(12)
            ->get();

        foreach ($products as $product) {
            $product->isNew = $product->created_at > $oneMonthAgo || $product->updated_at > $oneMonthAgo;
        }

        return $products;
    }

    public function showDiscountProducts()
    {
        $products2 = Product::with(['images', 'discount', 'category'])
            ->where('is_active', 1)
            ->where('quantity', '>', 0)
            ->whereHas('discount', function ($query) {
                $query->where('end_date', '>=', Carbon::today());
            })
            ->orderBy('updated_at', 'desc')
            ->limit(12)
            ->get();

        foreach ($products2 as $product2) {
            $product2->isDiscounted = true;
        }

        return $products2;
    }
}
