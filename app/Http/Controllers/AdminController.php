<?php

namespace App\Http\Controllers;

use App\Models\ProductsInOrder;
use Illuminate\Http\Request;
use App\Models\Order;

class


AdminController extends Controller
{
    public function index()
    {
        $newOrders = Order::all();
        return view('admin.admin', compact('newOrders'));
    }

    public function showProducts($orderId)
    {
        $order = Order::findOrFail($orderId);
        $products = ProductsInOrder::where('order_id', $orderId)->with('product')->get();

        return view('admin.orders.products', compact('order', 'products'));
    }

}
