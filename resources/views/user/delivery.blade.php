@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/delivery.css') }}">
    <title>Fishing Store - Доставка</title>
</head>

@section('content')

    <div class="container" style="max-width: 1600px;">
        @include('layouts.header-user')
        <div style="margin-top: 150px; margin-bottom: 100px; text-align: center;">
            <h2 style="margin-bottom: 50px;">Методи доставки</h2>

            <div class="delivery-section">
                <div class="delivery-card">
                    <img src="{{ asset('images/novaposhta.png') }}" alt="Нова Пошта" class="delivery-icon" style="margin-top: 50px; margin-bottom: 50px;">
                    <h3>Нова Пошта 🚚</h3>
                    <p>Швидка доставка по Україні через відділення Нової Пошти. <strong>Ціна: <span style="color: #b62020; font-weight: normal;">*Залежить від адреси замовлення</span></strong></p>
                </div>

                <div class="delivery-card">
                    <img src="{{ asset('images/ukrposhta.png') }}" alt="Укрпошта" class="delivery-icon">
                    <h3>Укрпошта 📦</h3>
                    <p>Економна доставка по всій території України через відділення Укрпошти. <strong>Ціна: 50 грн</strong></p>
                </div>

                <div class="delivery-card">
                    <img src="{{ asset('images/pickup.png') }}" alt="Самовивіз" class="delivery-icon" style="margin-top: 20px; margin-bottom: 60px;">
                    <h3>Самовивіз 🏠</h3>
                    <p>Безкоштовно заберіть своє замовлення з нашого магазину. <strong>Ціна: 0 грн</strong></p>
                </div>

                <div class="delivery-card">
                    <img src="{{ asset('images/courier.png') }}" alt="Доставка кур'єром" class="delivery-icon">
                    <h3>Доставка кур'єром 🚴‍♂️</h3>
                    <p>Зручна доставка замовлення прямо до вашого дому або офісу. <strong>Ціна: 200 грн</strong></p>
                </div>
            </div>
        </div>
        <div id="scrollToTop" class="scroll-to-top">
            <i class="fas fa-arrow-up"></i>
        </div>
    </div>
    @include('layouts.footer-user')

    <script src="{{ asset('js/user/delivery.js') }}"></script>

@endsection
