<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderTracking;
use App\Models\PaymentMethod;
use App\Models\ProductsInOrder;
use App\Models\ShippingMethod;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('user.main')->with('error', 'Будь ласка, увійдіть в акаунт, щоб перейти на сторінку адміністратора.');
        }

        $query = Order::with(['user', 'paymentMethod', 'shippingMethod', 'discount'])
            ->orderByDesc('created_at');


        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('id', 'like', '%' . $search . '%');
        }

        $paymentMethods = PaymentMethod::all();
        $shippingMethods = ShippingMethod::all();
        $discounts = Discount::all();

        $orders = $query->get();
        return view('admin.orders.index', compact('orders', 'paymentMethods', 'shippingMethods', 'discounts'));
    }


    public function create()
    {
        $users = User::all();
        $paymentMethods = PaymentMethod::all();
        $shippingMethods = ShippingMethod::all();
        $discounts = Discount::all();

        return view('admin.orders.create', compact('users', 'paymentMethods', 'shippingMethods', 'discounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'discount_id' => 'nullable|exists:discounts,id',
            'address' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);

        $order = Order::create($validated);

        OrderTracking::create([
            'order_id' => $order->id,
            'status' => $order->status,
            'updated' => now(),
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Замовлення створено успішно !!!');
    }


    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $users = User::all();
        $paymentMethods = PaymentMethod::all();
        $shippingMethods = ShippingMethod::all();
        $discounts = Discount::all();

        return view('admin.orders.edit', compact('order', 'users', 'paymentMethods', 'shippingMethods', 'discounts'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:50',
        ]);

        $order->update($validated);

        OrderTracking::create([
            'order_id' => $order->id,
            'status' => $order->status,
            'updated' => now(),
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Статус замовлення оновлено успішно !!!');
    }


    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('error', 'Замовлення видалено успішно !!!');
    }

    public function showProducts($orderId)
    {
        $order = Order::findOrFail($orderId);
        $products = ProductsInOrder::where('order_id', $orderId)->with('product')->get();

        return view('admin.orders.products', compact('order', 'products'));
    }

    public function filter(Request $request)
    {
        $query = $request->input('query');
        $paymentMethod = $request->input('paymentMethod');
        $shippingMethod = $request->input('shippingMethod');
        $discount = $request->input('discount');
        $priceMin = $request->input('priceMin');
        $priceMax = $request->input('priceMax');
        $status = $request->input('status');

        $orders = Order::query();

        if ($query) {
            $orders->where('name', 'like', '%' . $query . '%');
        }

        if ($paymentMethod) {
            $orders->where('payment_method_id', $paymentMethod);
        }

        if ($shippingMethod) {
            $orders->where('shipping_method_id', $shippingMethod);
        }

        if ($discount) {
            $orders->where('discount_id', $discount);
        }

        if ($priceMin) {
            $orders->where('total_amount', '>=', $priceMin);
        }

        if ($priceMax && $priceMax!="Infinity") {
            $orders->where('total_amount', '<=', $priceMax);
        }

        if ($status) {
            $orders->where('status', $status);
        }
        return response()->json([
            'orders' => $orders->with(['user', 'paymentMethod', 'shippingMethod', 'discount'])->get()
        ]);
    }

    public function pdfExportProductsInOrder(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $products = ProductsInOrder::where('order_id', $orderId)->with('product')->get();

        $pdf = PDF::loadView('admin.orders.export.pdf.invoiceProductsInOrder', compact('order', 'products'))
            ->setPaper('a4');

        return $pdf->download('check_' . now()->addHours(3)->format('Y-m-d_H_i_s') . '.pdf');
    }

    public function excelExport(Request $request)
    {
        $filteredOrder = Order::query();

        if ($request->filled('query')) {
            $filteredOrder->where('name', 'like', '%' . $request->input('query') . '%');
        }

        $orders = $filteredOrder->get(['id', 'user_id', 'payment_method_id', 'shipping_method_id', 'discount_id', 'address', 'total_amount', 'status', 'created_at']);

        return Excel::download(new OrdersExport($orders), 'orders_export_' . now()->addHours(3)->format('Y-m-d_H:i:s') . '.xlsx');
    }

    public function pdfExport(Request $request)
    {
        $filteredOrder = Order::query();

        if ($request->filled('query')) {
            $filteredOrder->where('name', 'like', '%' . $request->input('query') . '%');
        }

        $orders = $filteredOrder->get(['id', 'user_id', 'payment_method_id', 'shipping_method_id', 'discount_id', 'address', 'total_amount', 'status', 'created_at']);

        $pdf = PDF::loadView('admin.orders.export.pdf.invoice', compact('orders'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('orders_report_' . now()->addHours(3)->format('Y-m-d_H:i:s') . '.pdf');
    }

}
