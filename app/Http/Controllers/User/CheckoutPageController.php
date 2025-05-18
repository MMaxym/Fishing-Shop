<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\OrderReceiptMail;
use App\Models\Order;
use App\Models\OrderTracking;
use App\Models\Product;
use App\Models\ProductsInOrder;
use App\Services\LiqPayService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CheckoutPageController extends Controller
{
    /**
     * Відображення сторінки оформлення замовлення.
     */
    public function index()
    {
        $cart = session('cart', []);
        return view('user.checkoutPage', ['cart' => $cart]);
    }

    /**
     * Збереження вартості доставки у сесії.
     */
    public function deliveryCost(Request $request)
    {
        session(['deliveryCost' => $request->input('deliveryCost')]);
        return response()->json(['message' => 'Delivery cost saved in session']);
    }

    /**
     * Підтвердження замовлення, створення Order, відправка PDF, редірект на оплату або email.
     */
    public function confirmOrder(Request $request)
    {
        try {
            $shippingMethodId = $this->mapShippingMethod($request->input('shipping_method'));
            $paymentMethodId = $request->input('payment_method') === 'visa' ? 1 : 2;

            $order = Order::create([
                'user_id' => Auth::id(),
                'payment_method_id' => $paymentMethodId,
                'shipping_method_id' => $shippingMethodId,
                'address' => $request->input('address'),
                'total_amount' => $request->input('total_amount'),
                'status' => 'В обробці',
                'discount_id' => $request->input('discount_id'),
            ]);

            $products = $request->input('products');
            $this->storeProductsInOrder($products, $order);

            OrderTracking::create([
                'order_id' => $order->id,
                'status' => 'В обробці',
                'updated' => now(),
            ]);

            $pdfPath = $this->generateReceiptPdf($order, Auth::user(), $products, $request->input('shipping_method'));
            $email = $request->input('email');

            if ($paymentMethodId === 1) {
                // Оплата карткою — редірект на оплату
                $order->status = 'Очікує на оплату';
                $order->save();

                OrderTracking::create([
                    'order_id' => $order->id,
                    'status' => 'Очікує на оплату',
                    'updated' => now(),
                ]);

                return response()->json(['payment_url' => route('user.pay', ['order' => $order->id])]);
            }

            // Оплата при отриманні — надсилаємо email
            $this->sendReceiptEmailAsync($email, $order, Auth::user(), $products, $request->input('shipping_method'), $pdfPath);

            return response()->json([
                'message' => "Замовлення \"{$order->id}\" успішно створено! Чек на замовлення надіслано на Вашу електронну пошту"
            ], 200);
        } catch (\Exception $e) {
            Log::error('Помилка підтвердження замовлення: ' . $e->getMessage());
            return response()->json(['message' => 'Сталася помилка при створенні замовлення'], 500);
        }
    }

    /**
     * Відображення форми LiqPay.
     */
    public function pay(Order $order, LiqPayService $liqPayService)
    {
        $form = $liqPayService->generatePaymentForm($order);
        return view('payment.form', compact('form'));
    }

    /**
     * Callback від LiqPay — оновлення статусу замовлення.
     */
    public function callback(Request $request)
    {
        try {
            $data = $request->input('data');
            $signature = $request->input('signature');

            $liqpay = new \LiqPay(env('LIQPAY_PUBLIC_KEY'), env('LIQPAY_PRIVATE_KEY'));
            $decodedData = json_decode(base64_decode($data), true);

            $generatedSignature = base64_encode(sha1(env('LIQPAY_PRIVATE_KEY') . $data . env('LIQPAY_PRIVATE_KEY'), true));
            if ($signature !== $generatedSignature) {
                Log::warning('Invalid LiqPay signature', ['data' => $decodedData]);
                return response('Invalid signature', 403);
            }

            $order = Order::find($decodedData['order_id'] ?? null);
            if (!$order) {
                Log::warning('Order not found in callback', ['data' => $decodedData]);
                return response('Order not found', 404);
            }

            $order->status = match ($decodedData['status']) {
                'success', 'sandbox', 'wait_accept' => 'Оплачено',
                'failure', 'error', 'expired', 'reversed' => 'Оплата при отриманні',
                default => 'Очікує на оплату',
            };

            $order->save();

            return response('Callback processed', 200);
        } catch (\Exception $e) {
            Log::error('LiqPay callback error: ' . $e->getMessage());
            return response('Error', 500);
        }
    }

    // ------------------- Приватні допоміжні методи -------------------

    /**
     * Мапінг методу доставки на ID.
     */
    private function mapShippingMethod(string $method): int
    {
        return match ($method) {
            'nova-poshta' => 1,
            'ukrposhta'   => 2,
            'pickup'      => 3,
            'courier'     => 4,
            default       => throw new \Exception('Невідомий метод доставки'),
        };
    }

    /**
     * Додає продукти до замовлення та зменшує їх кількість.
     */
    private function storeProductsInOrder(array $products, Order $order): void
    {
        foreach ($products as $product) {
            ProductsInOrder::create([
                'order_id'  => $order->id,
                'product_id'=> $product['id'],
                'quantity'  => $product['quantity'],
                'price'     => $product['price'],
                'size'      => $product['size'] ?? null,
            ]);

            $currentQty = Product::where('id', $product['id'])->value('quantity');
            if ($currentQty >= $product['quantity']) {
                Product::where('id', $product['id'])->decrement('quantity', $product['quantity']);
            } else {
                throw new \Exception('Недостатня кількість продукту ' . $product['id']);
            }
        }
    }

    /**
     * Генерує PDF квитанцію про замовлення.
     */
    private function generateReceiptPdf(Order $order, $user, array $products, string $shippingMethod): string
    {
        $pdfPath = 'temp/order-receipt-' . $order->id . '.pdf';
        $pdf = Pdf::loadView('emails.order_receipt', compact('order', 'user', 'products', 'shippingMethod'));
        Storage::put($pdfPath, $pdf->output());
        return $pdfPath;
    }

    /**
     * Асинхронне надсилання PDF-чека на email.
     */
    private function sendReceiptEmailAsync($email, $order, $user, $products, $shippingMethod, $pdfPath): void
    {
        dispatch(function () use ($email, $order, $user, $products, $shippingMethod, $pdfPath) {
            Mail::to($email)->send(new OrderReceiptMail($order, $user, $products, $shippingMethod, Storage::path($pdfPath)));
            Storage::delete($pdfPath);
        });
    }

    public function getCartFromSession()
    {
        $cart = session('cart', []);
        return response()->json($cart);
    }

}
