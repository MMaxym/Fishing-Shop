<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductsInOrder;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('user.main')->with('error', 'Будь ласка, увійдіть в акаунт, щоб перейти на сторінку адміністратора.');
        }

        $newOrders = Order::orderBy('created_at', 'desc')->get();

        $currentDate = Carbon::now();
        $lastMonth =  Carbon::now()->startOfMonth();

        $orderCountLastMonth = Order::where('created_at', '>=', $lastMonth)
            ->where('created_at', '<=', $currentDate)
            ->where('status', 'Завершено')
            ->count();

        $totalSalesLastMonth = Order::where('created_at', '>=', $lastMonth)
            ->where('created_at', '<=', $currentDate)
            ->where('status', 'Завершено')
            ->sum('total_amount');

        $newCustomersLastMonth = User::where('created_at', '>=', $lastMonth)
            ->where('created_at', '<=', $currentDate)
            ->count();


        Carbon::setLocale('uk');

        $from = Carbon::now()->subMonths(11)->startOfMonth();
        $to = Carbon::now()->endOfMonth();

        $salesRaw = Order::whereBetween('created_at', [$from, $to])
            ->where('status', 'Завершено')
            ->selectRaw('SUM(total_amount) as total, DATE_FORMAT(created_at, "%Y-%m") as ym')
            ->groupByRaw('DATE_FORMAT(created_at, "%Y-%m")')
            ->orderByRaw('DATE_FORMAT(created_at, "%Y-%m")')
            ->get()
            ->pluck('total', 'ym');

        $salesByMonth = [];
        $current = $from->copy();
        while ($current <= $to) {
            $ym = $current->format('Y-m');
            $label = $current->translatedFormat('F Y');
            $salesByMonth[$label] = $salesRaw->get($ym, 0);
            $current->addMonth();
        }

        $categories = array_keys($salesByMonth);
        $quantities = array_values($salesByMonth);

        return view('admin.admin', compact(
            'newOrders',
            'orderCountLastMonth',
            'totalSalesLastMonth',
            'newCustomersLastMonth',
            'categories',
            'quantities'
        ));
    }

    public function showProducts($orderId)
    {
        $order = Order::findOrFail($orderId);
        $products = ProductsInOrder::where('order_id', $orderId)->with('product')->get();

        return view('admin.orders.products', compact('order', 'products'));
    }
}
