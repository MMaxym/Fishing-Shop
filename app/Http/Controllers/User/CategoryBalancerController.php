<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoryBalancerController extends Controller
{
    public function index(Request $request)
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        $sortOrder = $request->get('sort', 'none');
        $minPrice = $request->get('min_price', null);
        $maxPrice = $request->get('max_price', null);

//        DB::statement("UPDATE products, ".
//            "(select  p.id,(price * (1 - d.percentage / 100)) as actual ".
//            "from products p, discounts d ".
//            "where p.discount_id IS NOT NULL and p.discount_id = d.id ".
//            "union ".
//            "select  p.id,(price) as actual ".
//            "from products p ".
//            "where p.discount_id IS NULL ) test ".
//            "SET actual_price = test.actual ".
//            "WHERE products.id = test.id");


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
