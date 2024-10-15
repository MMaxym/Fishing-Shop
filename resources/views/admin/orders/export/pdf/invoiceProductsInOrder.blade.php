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
            width: 400px;
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
            font-weight: bold;
            margin-top: 10px;
        }
        .discount-price {
            text-decoration: line-through;
            color: red;
            text-align: right;
        }
        .final-price {
            font-weight: bold;
            color: green;
            text-align: right;
        }
        .footer-info {
            font-size: 10px;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Чек на замовлення №{{ $order->id }}</h2>
    <p>Дата: {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
    <p>Магазин: Fishing Shop</p>
    <p>Продавець: {{ Auth::check() ? Auth::user()->surname . ' ' . Auth::user()->name : 'Продавець 1' }}</p>
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
        @foreach($products as $productInOrder)
            <tr>
                <td>{{ $productInOrder->product->name }} ({{ $productInOrder->product->size }})</td>
                <td>{{ $productInOrder->quantity }}</td>
                <td>{{ number_format($productInOrder->product->price, 2) }} грн</td>
            </tr>
            @if($productInOrder->product->discount)
                <tr>
                    <td colspan="3" style="text-align: right;">
                        <span class="discount-price">{{ number_format($productInOrder->product->price * $productInOrder->quantity, 2) }} грн</span>
                        <br>
                        <span class="final-price">{{ number_format($productInOrder->product->price * (1 - $productInOrder->product->discount->percentage / 100) * $productInOrder->quantity, 2) }} грн</span>
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>

    <p class="total" style="border-top: 1px solid #000000;">Загальна знижка: {{ number_format($products->sum(fn($p) => ($p->product->discount ? ($p->product->price * $p->quantity) - ($p->product->price * (1 - $p->product->discount->percentage / 100) * $p->quantity) : 0)), 2) }} грн</p>
    <p class="total">Загальна сума (зі знижкою): {{ number_format($products->sum(fn($p) => ($p->product->price * (1 - ($p->product->discount->percentage ?? 0) / 100)) * $p->quantity), 2) }} грн</p>

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
