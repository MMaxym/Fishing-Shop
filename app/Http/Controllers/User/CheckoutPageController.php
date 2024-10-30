<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\OrderReceiptMail;
use App\Models\Order;
use App\Models\OrderTracking;
use App\Models\Product;
use App\Models\ProductsInOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class CheckoutPageController extends Controller
{
    public function index()
    {
        return view('user.checkoutPage');
    }

    public function confirmOrder(Request $request)
    {
        try {
            $shippingMethod = $request->input('shipping_method');
            $shippingMethodId = null;

            switch ($shippingMethod)
            {
                case 'nova-poshta':
                    $shippingMethodId = 1;
                    break;
                case 'ukrposhta':
                    $shippingMethodId = 2;
                    break;
                case 'pickup':
                    $shippingMethodId = 3;
                    break;
                case 'courier':
                    $shippingMethodId = 4;
                    break;
                default:
                    throw new \Exception('Невідомий метод доставки');
            }

            $shippingAddress = $request->input('address');
            $paymentMethodId = $request->input('payment_method') === 'visa' ? 1 : 2;

            $order = Order::create([
                'user_id' => Auth::user()->id,
                'payment_method_id' => $paymentMethodId,
                'shipping_method_id' => $shippingMethodId,
                'address' => $shippingAddress,
                'total_amount' => $request->input('total_amount'),
                'status' => 'В обробці',
                'discount_id' => $request->input('discount_id'),
            ]);

            $products = $request->input('products');
            foreach ($products as $product) {
                ProductsInOrder::create([
                    'order_id' => $order->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'size' => $product['size'] ?? null,
                ]);

                $currentQuantity = Product::where('id', $product['id'])->value('quantity');

                if ($currentQuantity >= $product['quantity']) {
                    Product::where('id', $product['id'])->decrement('quantity', $product['quantity']);
                }
                else {
                    return response()->json(['error' => 'Недостатня кількість продукту ' . $product['id']], 400);
                }
            }

            OrderTracking::create([
                'order_id' => $order->id,
                'status' => 'В обробці',
                'updated' => now(),
            ]);

            $user = Auth::user();
            $email = $request->input('email');

            $pdfPath = 'temp/order-receipt-' . $order->id . '.pdf';
            Storage::put($pdfPath, Pdf::loadView('emails.order_receipt', [
                'order' => $order,
                'user' => $user,
                'products' => $products ?? [],
                'shippingMethod' => $shippingMethod,
            ])->output());

            dispatch(function () use ($email, $order, $user, $products, $shippingMethod, $pdfPath) {
                Mail::to($email)->send(new OrderReceiptMail($order, $user, $products, $shippingMethod, Storage::path($pdfPath)));
                Storage::delete($pdfPath);
            });

//            $pdf = Pdf::loadView('emails.order_receipt', [
//                'order' => $order,
//                'user' => $user,
//                'products' => $products ?? [],
//                'shippingMethod' => $shippingMethod,
//            ]);
//            Mail::to($email)->send(new OrderReceiptMail($order, $user, $products, $shippingMethod, $pdf->output()));

            return response()->json(['message' => "Замовлення \"{$order->id}\" успішно створено! \nЧек на замовлення надіслано на Вашу електронну пошту"], 200);
        }
        catch (\Exception $e) {
            Log::error('Помилка підтвердження замовлення: ' . $e->getMessage());
            return response()->json(['message' => 'Сталася помилка при створенні замовлення'], 500);
        }
    }
    public function deliveryCost(Request $request){
        session(['deliveryCost' => $request->input('deliveryCost')]);
        return response()->json(['message' => 'Delivery cost saved in session']);
    }
}
