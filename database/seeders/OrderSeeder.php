<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run()
    {
        Order::create([
            'user_id' => 8,
            'payment_method_id' => 1,
            'shipping_method_id' => 1,
            'discount_id' => NULL,
            'address' => '123 Main St, Kyiv',
            'total_amount' => 1200.50,
            'status' => 'Створено',
            'created' => now(),
        ]);

        Order::create([
            'user_id' => 12,
            'payment_method_id' => 2,
            'shipping_method_id' => 1,
            'discount_id' => NULL,
            'address' => '456 Oak Rd, Lviv',
            'total_amount' => 800.75,
            'status' => 'В процесі',
            'created' => now(),
        ]);

        Order::create([
            'user_id' => 14,
            'payment_method_id' => 1,
            'shipping_method_id' => 2,
            'discount_id' => 1,
            'address' => '789 Pine St, Odesa',
            'total_amount' => 540.00,
            'status' => 'Виконано',
            'created' => now(),
        ]);

        Order::create([
            'user_id' => 15,
            'payment_method_id' => 2,
            'shipping_method_id' => 2,
            'discount_id' => NULL,
            'address' => '101 Maple Ave, Dnipro',
            'total_amount' => 2200.99,
            'status' => 'Відхилено',
            'created' => now(),
        ]);

        Order::create([
            'user_id' => 12,
            'payment_method_id' => 1,
            'shipping_method_id' => 1,
            'discount_id' => 2,
            'address' => '202 Birch Ln, Kharkiv',
            'total_amount' => 1560.25,
            'status' => 'Створено',
            'created' => now(),
        ]);
    }
}
