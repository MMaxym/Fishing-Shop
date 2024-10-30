<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Чек на замовлення №{{ $order->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 320px;
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #ccc;
        }
        h2, p {
            text-align: center;
            margin: 5px 0;
        }
        h2{
            margin-bottom: 35px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            border-bottom: 1px solid black;
        }
        .total {
            text-align: right;
            margin-top: 10px;
            font-weight: bold;
        }
        .discount-price {
            text-decoration: line-through;
            color: red;
            text-align: right;
            margin-top: 0;
        }
        .final-price {
            font-weight: bold;
            color: green;
            text-align: right;
            margin-top: 0;
        }
        .footer-info {
            font-size: 10px;
            text-align: center;
            margin-top: 15px;
        }
    </style>

</head>
<body>

<div class="container">
    <h2>Чек на замовлення №{{ $order->id }}</h2>
    <p>Дата: {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
    <p>Магазин: Fishing Shop</p>
{{--    <p>Продавець: {{ Auth::check() ? Auth::user()->surname . ' ' . Auth::user()->name : 'Продавець 1' }}</p>--}}
    <p>Продавець: Продавець 1</p>
    <p>Номер каси: інтернет-магазин</p>

    <h3 style="margin-top: 30px;">Список товарів:</h3>
    <table>
        <thead>
        <tr>
            <th>ТОВАР</th>
            <th>К-СТЬ</th>
            <th>ЦІНА</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($products) && is_iterable($products))
            @foreach($products as $productInOrder)
                <tr>
                    <td>{{ $productInOrder['name'] }} ({{ $productInOrder['size'] }})</td>
                    <td>{{ $productInOrder['quantity'] }}</td>
                    <td>{{ number_format($productInOrder['price'], 2) }} грн</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">
                        @if($productInOrder['price'] === $productInOrder['actualPrice'])
                            <span class="final-price">{{ number_format($productInOrder['actualPrice'] * $productInOrder['quantity'], 2) }} грн</span>
                        @endif
                        @if($productInOrder['price'] !== $productInOrder['actualPrice'])
                            <span class="discount-price">{{ number_format($productInOrder['price'] * $productInOrder['quantity'], 2) }} грн</span>
                            <br>
                            <span class="final-price">{{ number_format($productInOrder['actualPrice'] * $productInOrder['quantity'], 2) }} грн</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3" style="text-align: center;">Немає товарів у замовленні</td>
            </tr>
        @endif
        </tbody>
    </table>


    @php
        $totalPrice = array_reduce($products, function($carry, $product) {
            $discount = isset($product['discount']) ? $product['discount']['percentage'] : 0;
            $actualPrice = $product['actualPrice'] ?? 0;
            $quantity = $product['quantity'] ?? 1;

            $totalProductPrice = $actualPrice * $quantity * (1 - ($discount / 100));
            return $carry + $totalProductPrice;
        }, 0);

        $orderDiscountPercentage = 0;

        if ($totalPrice >= 3000) {
            $orderDiscountPercentage = 10;
        } elseif ($totalPrice >= 2000) {
            $orderDiscountPercentage = 5;
        } elseif ($totalPrice >= 1000) {
            $orderDiscountPercentage = 3;
        }

        $orderDiscountAmount = ($totalPrice * $orderDiscountPercentage) / 100;

       $deliveryCost = session('deliveryCost', 0);

        $finalTotal = $totalPrice + $deliveryCost - $orderDiscountAmount;
    @endphp

    <hr style="border: 1px solid black; margin: 20px 0;">

    <p class="total"  style="font-weight: bold;">
        Вартість товарів: {{ number_format(array_reduce($products, function($carry, $product) {
        $discount = isset($product['discount']) ? $product['discount']['percentage'] : 0;
        $actualPrice = $product['actualPrice'];
        $quantity = $product['quantity'];

        $totalPrice = $actualPrice * $quantity * (1 - ($discount / 100));
        return $carry + $totalPrice;
    }, 0), 2) }} грн
    </p>

    <p class="total" style="color: #808080;">
        Вартість доставки: {{ number_format($deliveryCost, 2) }} грн
    </p>

    <p class="total" style="color: #c53727;">
        Знижка на замовлення: {{ $orderDiscountPercentage }}% (-{{ number_format($orderDiscountAmount, 2) }} грн)
    </p>

    <p class="total" style="font-weight: bold; font-size: 16px;">
        ДО СПЛАТИ: {{ number_format($finalTotal, 2) }} грн
    </p>


    <div class="footer-info" style="margin-top: 30px;">
        <p>Дякуємо за покупку!</p>
        <p>Адреса магазину: м. Хмельницький, вул. Зарічанська, 10</p>
        <p>Час покупки: {{ now()->format('Y-m-d H:i:s') }}</p>
        <p>Телефон для звернень: +38 (044) 123 45 67</p>
        <p>Фіскальний чек №{{ rand(100000, 999999) }}</p>
        <p>Сайт магазину: fishing-shop.com</p>
        <p>Гарного Вам дня!!!</p>
    </div>

</div>

</body>
</html>
