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
    <h1>Звіт про користувачів системи №{{ rand(100000, 999999) }}</h1>
    <p>Дата: {{ now()->addHours(3)->format('Y-m-d H:i:s') }}</p>
</div>

<table>
    <thead>
    <tr>
        <th>№</th>
        <th>ЛОГІН</th>
        <th>ПРІЗВИЩЕ</th>
        <th>ІМʼЯ</th>
        <th>ЕЛЕКТРОННА ПОШТА</th>
        <th>ТЕЛЕФОН</th>
        <th>АДРЕСА</th>
        <th>РОЛЬ</th>
    </tr>
    </thead>
    <tbody>@php $i = 0; @endphp
    @foreach($users as $user)
        @php $i++ @endphp
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $user->login }}</td>
            <td>{{ $user->surname }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->address }}</td>
            <td>{{ $user->role->name }}</td>
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
