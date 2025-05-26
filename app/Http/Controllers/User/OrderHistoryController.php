<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('user.main')->with('error', 'Будь ласка, увійдіть в акаунт, щоб перейти на сторінку історії замовлень.');
        }

        $orders = Order::where('user_id', Auth::id())
            ->with(['products.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($orders as $order) {
            $order->productCountLabel = $this->getProductCountLabel($order->products->count());
        }

        return view('user.orderHistory', compact('orders'));
    }

    private function getProductCountLabel($count) {
        if ($count % 10 == 1 && $count % 100 != 11) {
            return 'товар';
        } elseif ($count % 10 >= 2 && $count % 10 <= 4 && ($count % 100 < 10 || $count % 100 >= 20)) {
            return 'товари';
        } else {
            return 'товарів';
        }
    }
}
