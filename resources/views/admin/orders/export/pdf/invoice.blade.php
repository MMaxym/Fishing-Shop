<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Звіт</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
        }
        .shop-info {
            margin-bottom: 30px;
        }
        .shop-info p {
            margin: 0;
        }
    </style>
</head>
<body>

<div class="shop-info">
    <p><strong>Fishing Shop</strong></p>
    <p>Телефон: +380 (98) 867 85 45</p>
    <p>Адреса: м. Хмельницький, вул. Зарічанська, 10</p>
    <p>Email: info@fishingshop.ua</p>
</div>

<div class="header">
    <h1>Звіт про всі замовлення №{{ rand(100000, 999999) }}</h1>
    <p>Дата: {{ now()->addHours(3)->format('Y-m-d H:i:s') }}</p>
</div>

<table>
    <thead>
    <tr>
        <th>№ ЗАМОВЛЕННЯ</th>
        <th>КОРИСТУВАЧ</th>
        <th>МЕТОД ОПЛАТИ</th>
        <th>МЕТОД ДОСТАВКИ</th>
        <th>ЗНИЖКА</th>
        <th>АДРЕСА</th>
        <th>СУМА</th>
        <th>СТАТУС</th>
        <th>СТВОРЕНО</th>

    </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->user->login }}</td>
            <td>{{ $order->paymentMethod->name }}</td>
            <td>{{ $order->shippingMethod->name }}</td>
            <td>{{ $order->discount_id ? ($order->discount ? $order->discount->percentage . '%' : 'Немає') : 'Немає' }}</td>
            <td>{{ $order->address }}</td>
            <td>{{ $order->total_amount }}</td>
            <td>{{ $order->status }}</td>
            <td>{{ $order->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="footer">
    <p>Сформовано: {{ auth()->user()->surname }} {{ auth()->user()->name }} ({{ auth()->user()->email }})</p>
    <p>Дата формування: {{ now()->addHours(3)->format('Y-m-d H:i:s') }}</p>
    <p>__________________ (Підпис)</p>
</div>
</body>
</html>
