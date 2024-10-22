<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryPilkerController extends Controller
{
    public function index(Request $request)
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        $sortOrder = $request->get('sort', 'none');
        $minPrice = $request->get('min_price', null);
        $maxPrice = $request->get('max_price', null);

        $minPriceFromDB = Product::whereHas('category', function ($query) {
            $query->where('name', 'Пількери');
        })->min('price');

        $maxPriceFromDB = Product::whereHas('category', function ($query) {
            $query->where('name', 'Пількери');
        })->max('price');

        $products = Product::with('images', 'discount')
            ->whereHas('category', function ($query) {
                $query->where('name', 'Пількери');
            });

        if ($minPrice !== null) {
            $products->where( 'price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $products->where('price', '<=', $maxPrice);
        }

        $products = $this->applySorting($products, $sortOrder);

        $products = $products->paginate(12);

        foreach ($products as $product) {
            $product->isDiscounted = !is_null($product->discount);
            $product->isNew = $product->created_at > $oneMonthAgo || $product->updated_at > $oneMonthAgo;
        }

        $currentPage = $products->currentPage();
        $perPage = $products->perPage();
        $totalItems = $products->total();
        $itemsShown = ($currentPage - 1) * $perPage + $products->count();

        return view('user.categoryPilkers', compact(
            'products', 'currentPage', 'perPage', 'totalItems', 'itemsShown',
            'sortOrder', 'minPrice', 'maxPrice', 'minPriceFromDB', 'maxPriceFromDB'
        ));
    }


    private function applySorting($products, $sortOrder)
    {
        if ($sortOrder == 'low_to_high') {
            return $products->orderBy('price', 'asc');
        } elseif ($sortOrder == 'high_to_low') {
            return $products->orderBy('price', 'desc');
        } elseif ($sortOrder == 'a_to_z') {
            return $products->orderBy('name', 'asc');
        } elseif ($sortOrder == 'z_to_a') {
            return $products->orderBy('name', 'desc');
        }

        return $products;
    }
}
