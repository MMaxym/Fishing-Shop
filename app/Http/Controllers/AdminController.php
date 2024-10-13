<?php

namespace App\Http\Controllers;

use App\Models\ProductsInOrder;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Carbon;
use function Laravel\Prompts\alert;

class AdminController extends Controller
{
    public function index()
    {
        $newOrders = Order::all();

        $currentDate = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

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

        $salesByMonth = Order::selectRaw('SUM(total_amount) as total, MONTH(created_at) as month')
            ->where('created_at', '<', $currentDate)
            ->where('status', 'Завершено')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $monthNames = [
            1 => 'Січень',
            2 => 'Лютий',
            3 => 'Березень',
            4 => 'Квітень',
            5 => 'Травень',
            6 => 'Червень',
            7 => 'Липень',
            8 => 'Серпень',
            9 => 'Вересень',
            10 => 'Жовтень',
            11 => 'Листопад',
            12 => 'Грудень',
        ];

        $salesByMonthFormatted = [];
        foreach ($salesByMonth as $month => $total) {
            $salesByMonthFormatted[$monthNames[$month]] = $total;
        }

        $categories = array_keys($salesByMonthFormatted);
        $quantities = array_values($salesByMonthFormatted);

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
