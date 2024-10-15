<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return $this->orders->map(function ($order) {
            return [
                'id' => $order->id,
                'user' => $order->user->login,
                'payment_method' => $order->paymentMethod ? $order->paymentMethod->name : 'Метод не знайдено',
                'shipping_method' => $order->shippingMethod ? $order->shippingMethod->name : 'Метод доставки не знайдено',
                'discount' => $order->discount_id ? ($order->discount ? $order->discount->percentage . '%' : 'Немає') : 'Немає',
                'address' => $order->address,
                'total_amount' => $order->total_amount,
                'status' => $order->status,
                'created_at' => $order->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            '№ ЗАМОВЛЕННЯ',
            'КОРИСТУВАЧ',
            'МЕТОД ОПЛАТИ',
            'МЕТОД ДОСТАВКИ',
            'ЗНИЖКА',
            'АДРЕСА',
            'СУМА',
            'СТАТУС',
            'СТВОРЕНО',
        ];
    }
}
