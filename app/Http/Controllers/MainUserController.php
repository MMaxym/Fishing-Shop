<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MainUserController extends Controller
{
    public function index()
    {
        return view('user.main');
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

}
