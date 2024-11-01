@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/orderHistory.css') }}">
</head>

@section('content')

    <div class="container" style="max-width: 1600px;">
        @include('layouts.header-user')
        <div style="margin-top: 120px; margin-bottom: 30px; text-align: center;">
            <p class="navigate">
                <a href="{{ route('user.main') }}" class="breadcrumb-link">
                    <i class="fa fa-home"></i> Головна
                </a>
                > Історія замовлень користувача {{ Auth::user()->surname }} {{ Auth::user()->name }}
            </p>
            <p class="contact" style="color:#04396e; font-size:16px; margin-left:1100px; max-width: 430px; text-align: right;">
                <i class="fas fa-phone" style="margin-right: 8px;"></i>ДЛЯ УТОЧНЕННЯ ДЕТАЛЕЙ ЗАМОВЛЕННЯ ЗВЕРТАЙТЕСЬ ЗА ТЕЛЕФОНОМ: <span style="font-size: 18px; font-weight: 600;">+380 (98) 867 85 45</span>
            </p>
            <h2 class="page-title">ІСТОРІЯ ЗАМОВЛЕНЬ</h2>
        </div>

        <div class="order-history-container">
            @if($orders->isEmpty())
                <p>У вас ще немає замовлень.</p>
            @else
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-info">
                            <div class="order-header" style="font-size: 20px;">
                                <span>Замовлення <strong>№{{ $order->id }}</strong></span>
                            </div>
                            <div class="order-date" style="font-size: 16px; color: #686868; margin-bottom: 10px; margin-top: 5px;">
                                <span class="date">від {{ $order->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                            <div class="order-status" style="margin-bottom: 10px;">
                                <strong>{{ $order->status }}</strong>
                            </div>
                            <div class="order-summary">
                                <div class="order-items-count">
                                    <span>{{ $order->products->count() }} {{ $order->productCountLabel }}</span>
                                </div>
                                <div class="order-total-amount">
                                    <span class="order-total">Разом:</span>
                                    <strong>{{ number_format($order->total_amount, 0) }} грн</strong>
                                </div>
                            </div>
                            <button class="btn-details" onclick="toggleOrderItems({{ $order->id }})">
                                <i class="fa fa-list"></i> Деталі замовлення
                            </button>
                        </div>

                        <div id="order-items-{{ $order->id }}" class="order-items" style="display: none;">
                            <h5>Історія змін:</h5>
                            <ul class="order-status-history">
                                @foreach($order->tracking as $tracking)
                                    <li class="status-item">
                                        <i class="fa fa-check-circle status-icon" aria-hidden="true"></i>
                                        <strong>{{ $tracking->status}}</strong> <splan style="margin: 0 10px;"> — </splan> {{ $tracking->updated_at->format('d.m.Y H:i') }}
                                    </li>
                                @endforeach
                            </ul>


                        @if($order->products->isEmpty())
                                <p class="no-items">Це замовлення не містить товарів.</p>
                            @else
                                <h5 style="margin-top: 40px;">Перелік товарів:</h5>
                                <ul class="order-products-list">
                                    @foreach($order->products as $item)
                                        <li class="order-product-item">
                                            <span class="product-name">{{ $item->product->name }}</span>
                                            <span class="product-quantity">Кількість: {{ $item->quantity }}</span>
                                            <span class="product-price">{{ number_format($item->price, 2) }} грн</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div id="scrollToTop" class="scroll-to-top">
            <i class="fas fa-arrow-up"></i>
        </div>
    </div>

    <script>
        function toggleOrderItems(orderId) {
            var itemsDiv = document.getElementById('order-items-' + orderId);
            itemsDiv.style.display = (itemsDiv.style.display === 'none') ? 'block' : 'none';
        }

        window.onscroll = function () {
            const scrollToTopButton = document.getElementById("scrollToTop");
            if (window.scrollY > 200) {
                scrollToTopButton.style.display = "block";
            } else {
                scrollToTopButton.style.display = "none";
            }
        };

        document.getElementById("scrollToTop").onclick = function () {
            window.scrollTo({ top: 0, behavior: "smooth" });
        };

    </script>

    @include('layouts.footer-user')
@endsection
