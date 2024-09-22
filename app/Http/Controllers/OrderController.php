<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;
use App\Models\ProductsInOrder;
use App\Models\Discount;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'paymentMethod', 'shippingMethod', 'discount'])->get();
        return view('admin.orders.index', compact('orders'));
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

        Order::create($validated);

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

        return redirect()->route('admin.orders.index')->with('success', 'Статус замовлення оновлено успішно !!!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('error', 'Замовлення видалено успішно !!!');
    }

    public function search(Request $request)    //не працює пошук, тому що id типу string
    {
        $query = $request->input('query');

        $orders = Order::where('id', 'like', "%$query%")
            ->with(['user', 'paymentMethod', 'shippingMethod', 'discount'])
            ->get();

        return response()->json(['orders' => $orders]);
    }

    public function showProducts($orderId)
    {
        $order = Order::findOrFail($orderId);
        $products = ProductsInOrder::where('order_id', $orderId)->with('product')->get();

        return view('admin.orders.products', compact('order', 'products'));
    }


}
