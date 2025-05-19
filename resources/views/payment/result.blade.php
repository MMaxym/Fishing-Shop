@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/payment/result.css') }}">
    <title>Fishing Store</title>
</head>

@section('content')

    <div class="main-container">
        <a href="{{ route('user.main') }}" class="logo-link">
            <img class="logo-icon" alt="Logo" title="Перейти на головну" src="{{ asset('images/v2/img/logo.svg') }}">
        </a>
        <div class="content">
            <h2 class="payment-title">
                <img class="icon-done" alt="arrow" src="{{ asset('images/v2/icon/DoneFilled.svg') }}">
                Дякуємо! Оплату успішно здійснено.
            </h2>
            <p class="payment-description">Ми отримали ваше замовлення. Найближчим часом з вами зв'яжеться наш менеджер.</p>
            <a class="redirect-to-main" href="{{route('user.main')}}">
                Повернутися на головну
                <img class="icon-arrow-right" alt="arrow" src="{{ asset('images/v2/icon/ArrowSmallRight.svg') }}">
            </a>
            <img class="background-img" alt="Pay Image" src="{{ asset('images/v2/img/payment-img.svg') }}">
        </div>
    </div>

@endsection





