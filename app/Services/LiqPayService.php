<?php

namespace App\Services;

use LiqPay;

class LiqPayService
{
    protected $liqpay;

    public function __construct()
    {
        $this->liqpay = new LiqPay(env('LIQPAY_PUBLIC_KEY'), env('LIQPAY_PRIVATE_KEY'));
    }

    public function generatePaymentForm($order)
    {
        $params = [
            'action'         => 'pay',
            'amount'         => $order->total_amount,
//            'amount'         => 1.02,
            'currency'       => 'UAH',
            'description'    => 'Оплата замовлення #' . $order->id,
            'order_id'       => $order->id,
            'version'        => '3',
            'sandbox'        => 1,
            'result_url'     => route('liqpay.result'),
            'server_url' => env('NGROK_URL') . '/user/liqpay/callback',
        ];

        return $this->liqpay->cnb_form($params);
    }
}
