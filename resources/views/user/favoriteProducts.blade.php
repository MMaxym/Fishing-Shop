@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/favoriteProducts.css') }}">
</head>

@section('content')

    @include('layouts.header-user')

    <main class="main-section">
        <section class="main-row" id="main-row-product-details">
            <div class="main-row-wrapper">
                <nav aria-label="breadcrumb" class="page-navigation">
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item">
                            <a href="{{ route('user.main') }}">
                                <img src="{{ asset('images/v2/icon/HomeFilled.svg') }}" alt="Home Icon">
                                Головна
                            </a>
                            <span class="breadcrumb-separator">
                                <img src="{{ asset('images/v2/icon/ArrowSmallRightNav.svg') }}" alt="Arrow Icon">
                            </span>
                        </li>
                        <li class="current-product">Улюблені товари</li>
                    </ul>
                </nav>
            </div>
        </section>

        <section class="main-row">
            <div class="products-wrapper">
                <h2 class="row-title">Улюблені товари</h2>
                <div class="cart-products-grid" id="favorite-products-container">
                    @if($products->count())
                        @include('partials.favorite-products', ['products' => $products])
                    @else
                        <div class="empty-cart">
                            <p class="empty-cart-text">Ви ще не вподобали жоден товар.</p>
                            <button class="empty-cart-btn" onclick="window.location.href='{{ route('user.main') }}'">Продовжити покупки
                                <img  class="empty-cart-btn-icon" src="{{ asset('images/v2/icon/ArrowBigRightHomeLink.svg') }}" alt="moreIcon">
                            </button>
                            <img  class="empty-cart-img" src="{{ asset('images/v2/img/not-found-products-img.svg') }}" alt="emptyIcon">
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <div class="decoration-row" id="decoration-row-details-product">
            <img src="{{ asset('images/v2/img/decoration-img.svg') }}" alt="Розділювач" class="decoration-img">
        </div>

        @if($recentlyViewedProducts->isNotEmpty())
            <section class="main-row">
                <div class="recently-products-wrapper">
                    <h2 class="row-title">Нещодавно переглянуті</h2>
                    <div class="recently-products-scroll-container" id="recently-products-scroll-container">
                        @include('partials.recently-products', ['products' => $recentlyViewedProducts])
                    </div>
                </div>
            </section>
        @endif
    </main>

    @include('layouts.footer-user')

    <script src="{{ asset('js/user/favoriteProducts.js') }}"></script>

@endsection

