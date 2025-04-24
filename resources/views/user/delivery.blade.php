@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/delivery.css') }}">
</head>

@section('content')

    @include('layouts.header-user')

    <main class="main-section">
        <section class="main-row">
            <div class="delivery-section">
                <div class="delivery-headers">
                    <h2 class="delivery-title">Доставка у нашому магазині</h2>
                    <p class="delivery-description">
                        Ми подбали про зручність кожного рибалки, тож пропонуємо кілька варіантів доставки на Ваш вибір
                    </p>
                </div>

                <div class="delivery-cards">
                    <div class="delivery-card">
                        <div class="delivery-img">
                            <img src="{{ asset('images/novaposhta.png') }}" alt="Нова Пошта" class="delivery-logo">
                        </div>
                        <h3 class="delivery-name">Нова Пошта</h3>
                        <p class="delivery-text">Швидка доставка по Україні через відділення Нової Пошти</p>
                        <p class="delivery-price red">Від 100 грн</p>
                        <span class="delivery-price-warning">* Залежить від адреси замовлення</span>
                    </div>

                    <div class="delivery-card">
                        <div class="delivery-img" id="delivery-img-ukrposhta">
                            <img src="{{ asset('images/ukrposhta2.png') }}" alt="Укрпошта" class="delivery-logo">
                        </div>
                        <h3 class="delivery-name">Укрпошта</h3>
                        <p class="delivery-text">Економна доставка по всій території України через відділення Укрпошти</p>
                        <p class="delivery-price red">Від 50 грн</p>
                        <span class="delivery-price-warning">* Залежить від адреси замовлення</span>
                    </div>

                    <div class="delivery-card">
                        <div class="delivery-img" id="delivery-img-pickup">
                            <img src="{{ asset('images/v2/img/pickup-img.svg') }}" alt="Самовивіз" class="delivery-logo">
                        </div>
                        <h3 class="delivery-name">Самовивіз</h3>
                        <p class="delivery-text">Безкоштовно заберіть своє замовлення з нашого магазину</p>
                        <p class="delivery-price red">Безкоштовно</p>
                    </div>

                    <div class="delivery-card">
                        <div class="delivery-img" id="delivery-img-courier">
                            <img src="{{ asset('images/v2/img/courier-img.svg') }}" alt="Самовивіз" class="delivery-logo">
                        </div>
                        <h3 class="delivery-name">Доставка кур'єром</h3>
                        <p class="delivery-text">Зручна доставка замовлення прямо до вашого дому або офісу</p>
                        <p class="delivery-price red">250 грн</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layouts.footer-user')

    <script src="{{ asset('js/user/delivery.js') }}"></script>

@endsection
