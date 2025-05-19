@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/payment/form.css') }}">
    <title>Fishing Store</title>
</head>

@section('content')

    <div class="main-container">
        <a href="{{ route('user.main') }}" class="logo-link">
            <img class="logo-icon" alt="Logo" title="Перейти на головну" src="{{ asset('images/v2/img/logo.svg') }}">
        </a>
        <div class="content">
            <h2 class="payment-title">Оплата через LiqPay</h2>
            <div class="liqpay-form-wrapper">
                {!! $form !!}
            </div>
            <img class="background-img" alt="Pay Image" src="{{ asset('images/v2/img/payment-img.svg') }}">
        </div>
    </div>

@endsection
