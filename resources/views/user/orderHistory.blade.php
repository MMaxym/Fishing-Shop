@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/orderHistory.css') }}">
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
                        <li class="current-product"> Історія замовлень</li>
                    </ul>
                </nav>
            </div>
        </section>

        <section class="main-row">
            <div class="products-wrapper">
                <h2 class="row-title">Історія замовлень</h2>

                <div class="history-products">
                    <div class="history-items-container">

                        @if($orders->isNotEmpty())
                            <div class="history-table-head">
                                <div class="col number-title">Номер</div>
                                <div class="col date-title">Дата</div>
                                <div class="col status-title">Статус</div>
                                <div class="col quantity-title">К-сть</div>
                                <div class="col total-title">Вартість</div>
                            </div>
                        @endif

                        @if($orders->isNotEmpty())
                            @foreach($orders as $order)
                                <div class="faq-item">
                                    <div class="faq-question">
                                        @php
                                            $statusClassMap = [
                                                'В обробці' => 'status-in-process',
                                                'Очікує на оплату' => 'status-awaiting-payment',
                                                'Доставлено' => 'status-delivered',
                                                'Завершено' => 'status-completed',
                                                'Скасовано' => 'status-cancelled',
                                            ];
                                            $statusClass = $statusClassMap[$order->status] ?? 'status-unknown';
                                        @endphp
                                        <span class="faq-number">№ {{ $order->id }}</span>
                                        <span class="faq-date">від {{ $order->created_at->format('d.m.Y H:i') }}</span>
                                        <span class="faq-status {{ $statusClass }}">{{ $order->status }}</span>
                                        <span class="faq-count">{{ $order->products->count() }} {{ $order->productCountLabel }}</span>
                                        <span class="faq-price">{{ number_format($order->total_amount,  0, ' ', ' ') }} грн</span>
                                        <button class="toggle-answer" aria-label="Toggle answer">
                                            <img class="arrow-icon"
                                                 src="{{ asset('images/v2/icon/ArrowSmallDownFAQ.svg') }}"
                                                 alt="ArrowIcon">
                                        </button>
                                    </div>
                                    <div class="faq-answer">
                                        <div class="order-statuses">
                                            <h3 class="order-statuses-title">Історія змін</h3>
                                            <div class="order-statuses-wrapper">
                                                <ul class="order-statuses-stepper">
                                                    @foreach($order->tracking as $tracking)
                                                        @php
                                                            $statusClassMap = [
                                                                'В обробці' => 'in-process',
                                                                'Очікує на оплату' => 'awaiting-payment',
                                                                'Доставлено' => 'delivered',
                                                                'Завершено' => 'completed',
                                                                'Скасовано' => 'cancelled',
                                                            ];
                                                            $statusSlug = $statusClassMap[$tracking->status] ?? 'unknown-status';
                                                        @endphp
                                                        <li class="step {{ $statusSlug }}">
                                                            <div class="circle">
                                                                <div class="inner-circle"></div>
                                                            </div>
                                                            <div class="label">
                                                                <span class="status-name">{{ $tracking->status }}</span>
                                                                <span
                                                                    class="status-time">{{ $tracking->updated_at->format('d.m.Y H:i') }}</span>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="order-products">
                                            <h3 class="order-products-title">Перелік товарів</h3>

                                            @foreach($order->products as $item)
                                                <div class="order-product-item">
                                                    <div class="product-image">
                                                        <img src="{{ $item->product->images->first() ? asset('storage/' . $item->product->images->first()->image_url) : '/images/no-image.png' }}"
                                                             alt="{{ $item->product->name }}">
                                                    </div>
                                                    <div class="product-item-details">
                                                        <div class="product-name">{{ $item->product->name }}</div>
                                                        <div class="product-article">арт. {{ $item->product->article}}</div>
                                                    </div>
                                                    <div class="product-quantity">Кількість: {{ $item->quantity }}</div>
                                                    <div class="product-price">{{ number_format($item->price,  0, ' ', ' ') }} грн</div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @else
                             <div class="empty-cart">
                                <p class="empty-cart-text">У вас ще немає замовлень.</p>
                                <button class="empty-cart-btn" onclick="window.location.href='{{ route('user.main') }}'">Продовжити покупки
                                   <img  class="empty-cart-btn-icon" src="{{ asset('images/v2/icon/ArrowBigRightHomeLink.svg') }}" alt="moreIcon">
                                </button>
                                <img  class="empty-cart-img" src="{{ asset('images/v2/img/not-found-products-img.svg') }}" alt="emptyIcon">
                             </div>
                        @endif
                    </div>

                    @if($orders->isNotEmpty())
                        <div class="col-section">
                            <h4 class="col-title">Зворотній звʼязок</h4>
                            <div class="col-main">
                                <div class="col-text">
                                    <img class="col-icon" alt="Logo"
                                         src="{{ asset('images/v2/icon/PhoneOutlineFooter.svg') }}">
                                    <div class="col-text-row">
                                        <p class="col-text-row-title">+380 (98) 867 85 45</p>
                                    </div>
                                </div>
                                <div class="col-text">
                                    <img class="col-icon" alt="Logo"
                                         src="{{ asset('images/v2/icon/PhoneOutlineFooter.svg') }}">
                                    <div class="col-text-row">
                                        <p class="col-text-row-title">+380 (97) 225 02 48</p>
                                    </div>
                                </div>

                            </div>
                            <div class="col-text">
                                <p class="col-text-row-title" id="col-text-row-title">* Для уточнення деталей замовлення або
                                    оформлення повернення замовлення, будь ласка, зателефонуйте нам.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/user/orderHistory.js') }}"></script>

    @include('layouts.footer-user')

@endsection

