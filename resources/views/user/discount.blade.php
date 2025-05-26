@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/discount.css') }}">
</head>

@section('content')

    @include('layouts.header-user')

    <main class="main-section">
        <section class="main-row">
            <div class="discount-content">
                <div class="discount-text-title">
                    <h2 class="discount-title">Знижки на замовлення</h2>
                    <p class="discount-subtitle">Лови момент — твоя приманка чекає на знижку вже сьогодні!</p>
                </div>
                <div class="discount-cards">
                    @forelse ($orderDiscounts as $discount)
                        <div class="discount-card">
                            <div class="discount-info">
                                <div class="discount-percent">{{ $discount->percentage }}%</div>
                                <div class="discount-date">
                                    {{ $discount->start_date->format('d.m.Y') }} – {{ $discount->end_date->format('d.m.Y') }}
                                </div>
                            </div>
                            <div class="discount-text">{{ $discount->description }}</div>
                        </div>
                    @empty
                        <p class="no-sale">* Наразі немає активних знижок на замовлення.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="main-row">
            <div class="discount-content">
                <div class="discount-text-title">
                    <h2 class="discount-title">Знижки на товари</h2>
                    <p class="discount-subtitle">Слідкуй за оновленнями — ми часто додаємо нові акції, сезонні знижки та спеціальні пропозиції.</p>
                </div>
                @forelse ($productDiscounts as $discount)
                    <div class="discount-card-products">
                        <div class="discount-left-products">
                            <div class="discount-left-products-text">
                                <div class="discount-percent-products">-{{ $discount->percentage }}%</div>
                                <div class="discount-name-products">{{ $discount->name }}</div>
                            </div>
                            <div class="discount-image-products">
                                <img src="{{ asset('images/v2/img/products-sale-img.svg') }}" alt="Знижка">
                            </div>
                        </div>
                        <div class="discount-right-products">
                            <div class="discount-timer-products" data-end-date="{{ $discount->end_date->format('Y-m-d H:i:s') }}">
                                До завершення акції: <span class="timer-value-products">Завантаження...</span>
                            </div>

                            <div class="discount-heading-products">
                                <strong>{{ $discount->name }}!</strong>
                                <span class="discount-link-products"> -{{ $discount->percentage }}% на певні вибрані товари</span>
                            </div>
                            <div class="discount-period-products">
                                Акція діє з {{ $discount->start_date->format('d.m.Y') }} по {{ $discount->end_date->format('d.m.Y') }}
                            </div>
                            <div class="discount-description-products">
                                {{ $discount->description }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="no-sale">* Наразі немає активних знижок на замовлення.</p>
                @endforelse
            </div>
        </section>
    </main>

    @include('layouts.footer-user')

    <script src="{{ asset('js/user/discount.js') }}"></script>

@endsection
