@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/admin/adminMain.css') }}">
    <title>Fishing Store</title>
</head>

@section('content')

    @include('layouts.header-admin')

    <main class="main-section">

        <section class="main-row">
            <div class="nav-section">
                <nav class="navigate-category">
                    <a href="{{route('admin.admin')}}" class="navigate-link active" id="navigate-link-content-top">
                        <div class="navigate-link-content" id="navigate-link-content-top">
                            <img src="{{ asset('images/v2/icon/HomeFilled.svg') }}" alt="Новинки" class="navigate-icon">
                            <span class="navigate-text">Головна</span>
                        </div>
                    </a>
                    <a href="{{route('admin.users.index')}}" class="navigate-link">
                        <div class="navigate-link-content">
                            <img src="{{ asset('images/v2/icon/UserFilled.svg') }}" alt="Акційні товари" class="navigate-icon">
                            <span class="navigate-text">Користувачі</span>
                        </div>
                    </a>
                    <a href="{{route('admin.products.index')}}" class="navigate-link">
                        <div class="navigate-link-content">
                            <img src="{{ asset('images/v2/icon/PriceFilled.svg') }}" alt="Балансири" class="navigate-icon">
                            <span class="navigate-text">Товари</span>
                        </div>
                    </a>
                    <a href="{{route('admin.orders.index')}}" class="navigate-link">
                        <div class="navigate-link-content">
                            <img src="{{ asset('images/v2/icon/BasketFilled.svg') }}" alt="Балансири" class="navigate-icon">
                            <span class="navigate-text">Замовлення</span>
                        </div>
                    </a>
                    <a href="{{route('admin.discounts.index')}}" class="navigate-link">
                        <div class="navigate-link-content">
                            <img src="{{ asset('images/v2/icon/SaleFilled.svg') }}" alt="Балансири" class="navigate-icon">
                            <span class="navigate-text">Знижки</span>
                        </div>
                    </a>
                    <a href="{{route('admin.admin')}}" class="navigate-link">
                        <div class="navigate-link-content">
                            <img src="{{ asset('images/v2/icon/OrderlistButton.svg') }}" alt="Тейл-спінери" class="navigate-icon" style="width: 28px; height: 28px;">
                            <span class="navigate-text">Популярні запитання</span>
                        </div>
                    </a>
                    <a href="#" class="navigate-link" id="logout-link">
                        <div class="navigate-link-content">
                            <img src="{{ asset('images/v2/icon/LogOutOutlineEditProfile.svg') }}" alt="Вийти" class="navigate-icon">
                            <span class="navigate-text">Вийти з акаунту</span>
                        </div>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </nav>
            </div>

            <section class="slider-section">
                <h2 class="admin-title">Адмін-панель</h2>
                <div class="dashboard-widgets">
                    <div class="widget">
                        <div class="widget-header">
                            <div class="widget-content">
                                <span class="widget-title">Нові замовлення</span>
                                <div class="widget-value">{{ $orderCountLastMonth ?? 0 }}</div>
                            </div>
                            <div class="widget-icon blue">
                                <img src="{{ asset('images/v2/icon/BasketFilledWidget.svg') }}" alt="Балансири" class="widget-icon-icon">
                            </div>
                        </div>
                        <div class="widget-subtext">Аналітика за останній місяць</div>
                    </div>

                    <div class="widget">
                        <div class="widget-header">
                            <div class="widget-content">
                                <span class="widget-title">Сума продажів</span>
                                <div class="widget-value">{{  number_format($totalSalesLastMonth, 0, ' ', ' ') ?? 0 }} грн</div>
                            </div>
                            <div class="widget-icon green">
                                <img src="{{ asset('images/v2/icon/PriceFilledWidget.svg') }}" alt="Балансири" class="widget-icon-icon">
                            </div>
                        </div>
                        <div class="widget-subtext">Аналітика за останній місяць</div>
                    </div>

                    <div class="widget">
                        <div class="widget-header">
                            <div class="widget-content">
                                <span class="widget-title">Нові клієнти</span>
                                <div class="widget-value">{{ $newCustomersLastMonth ?? 0 }}</div>
                            </div>
                            <div class="widget-icon red">
                                <img src="{{ asset('images/v2/icon/UserFilledWidget.svg') }}" alt="Балансири" class="widget-icon-icon">
                            </div>
                        </div>
                        <div class="widget-subtext">Аналітика за останній місяць</div>
                    </div>
                </div>
                <section class="order-card">
                    <div class="order-card__header">
                        <h5 class="order-card__title">Нові замовлення <span class="order-card__title-now">За сьогодні ({{ now()->format('d.m.Y') }})</span></h5>
                    </div>
                    <div class="order-card__body">
                        <div class="order-table">
                            <div class="history-table-head">
                                <div class="col number-title">№ замовлення</div>
                                <div class="col customer-title">Замовник</div>
                                <div class="col status-title">Статус</div>
                                <div class="col total-title">Вартість</div>
                                <div class="col date-title">Дата</div>
                                <div class="col details-title">Деталі</div>
                            </div>

                            <ul class="order-list">
                                @if($newOrders->isEmpty() || !$newOrders->contains(fn ($order) => \Carbon\Carbon::parse($order->created_at)->isToday()))
                                    <li class="order-list__item empty">
                                        <div class="col">—</div>
                                        <div class="col" colspan="5"><em>* Нових замовлень за сьогодні немає.</em></div>
                                    </li>
                                @else
                                    @foreach($newOrders as $order)
                                        @if(\Carbon\Carbon::parse($order->created_at)->isToday())
                                            @php
                                                $statusClassMap = [
                                                    'В обробці' => 'status-in-process',
                                                    'Створено' => 'status-in-process',
                                                    'Очікує на оплату' => 'status-awaiting-payment',
                                                    'Оплачено' => 'status-completed',
                                                    'Доставлено' => 'status-delivered',
                                                    'Завершено' => 'status-completed',
                                                    'Скасовано' => 'status-cancelled',
                                                ];
                                                $statusClass = $statusClassMap[$order->status] ?? 'status-unknown';
                                            @endphp
                                            <li class="order-list__item">
                                                <div class="col">#{{ $order->id }}</div>
                                                <div class="col">{{ $order->user->surname }} {{ $order->user->name }} ({{$order->user->phone}})</div>
                                                <div class="col">
                                                    <span class="faq-status {{ $statusClass }}">{{ $order->status }}</span>
                                                </div>
                                                <div class="col">{{ number_format($order->total_amount, 0, ' ', ' ') }} грн</div>
                                                <div class="col">{{ $order->created_at->format('d.m.Y H:i') }}</div>
                                                <div class="col">
                                                    <a href="{{ route('admin.orders.products', $order->id) }}" class="view-btn" title="Переглянути">
                                                        <i class="fas fa-list-ul"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </section>

                <section class="order-card" style="height: 500px;">
                    <div class="order-card__header">
                        <h5 class="order-card__title">Динаміка прибутку інтернет-магазину <span class="order-card__title-now">За останні 12 місяців</span></h5>
                    </div>
                    <div class="order-card__body">
                        <div class="graphic"></div>
                        <div class="graphic-wrapper">
                            <canvas id="graphic" width="400" height="155" style="padding: 14px;"></canvas>
                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const ctx = document.getElementById('graphic').getContext('2d');

                                    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                                    gradient.addColorStop(0, 'rgba(42, 142, 158, 0.3)');
                                    gradient.addColorStop(1, 'rgba(42, 142, 158, 0)');

                                    const chart = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: @json($categories),
                                            datasets: [{
                                                label: 'Динаміка прибутку',
                                                data: @json($quantities),
                                                borderColor: '#2a8e9e',
                                                backgroundColor: gradient,
                                                pointBackgroundColor: '#2a8e9e',
                                                pointBorderColor: '#fff',
                                                pointRadius: 5,
                                                pointHoverRadius: 10,
                                                tension: 0.4,
                                                fill: true,
                                                borderWidth: 3,
                                                hoverBorderWidth: 5,
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            interaction: {
                                                mode: 'nearest',
                                                intersect: true,
                                            },
                                            plugins: {
                                                legend: {
                                                    display: true,
                                                    position: 'top',
                                                    labels: {
                                                        color: '#333',
                                                        font: {
                                                            size: 14,
                                                            weight: 'bold'
                                                        }
                                                    }
                                                },
                                                tooltip: {
                                                    enabled: true,
                                                    backgroundColor: '#2a8e9e',
                                                    titleColor: '#fff',
                                                    bodyColor: '#fff',
                                                    borderWidth: 1,
                                                    borderColor: '#fff',
                                                    padding: 10,
                                                    animation: true,
                                                    animationDuration: 400,
                                                    callbacks: {
                                                        label: function(context) {
                                                            return `Прибуток: ${context.formattedValue} грн`;
                                                        }
                                                    }
                                                }
                                            },
                                            scales: {
                                                x: {
                                                    ticks: {
                                                        color: '#555'
                                                    },
                                                    grid: {
                                                        display: false
                                                    }
                                                },
                                                y: {
                                                    beginAtZero: true,
                                                    ticks: {
                                                        color: '#555'
                                                    },
                                                    grid: {
                                                        color: 'rgba(0, 0, 0, 0.05)'
                                                    }
                                                }
                                            },
                                            animation: {
                                                duration: 2000,
                                                easing: 'easeOutQuart'
                                            },
                                            hover: {
                                                onHover: function(event, elements) {
                                                    const point = elements[0];
                                                    if (point) {
                                                        ctx.canvas.style.cursor = 'pointer';
                                                    } else {
                                                        ctx.canvas.style.cursor = 'default';
                                                    }
                                                }
                                            }
                                        },
                                        plugins: [{
                                            id: 'pulsePoint',
                                            afterDraw(chart) {
                                                const ctx = chart.ctx;
                                                const points = chart.getDatasetMeta(0).data;

                                                points.forEach(point => {
                                                    if (point.$context.hover) {
                                                        const pulseRadius = point._model ? point._model.radius + 10 : 15;
                                                        let alpha = 0.3;

                                                        let pulseAnimation = () => {
                                                            alpha = (alpha >= 0.7) ? 0.3 : alpha + 0.02;
                                                            ctx.save();
                                                            ctx.beginPath();
                                                            ctx.arc(point.x, point.y, pulseRadius, 0, Math.PI * 2);
                                                            ctx.strokeStyle = `rgba(42, 142, 158, ${alpha})`;
                                                            ctx.lineWidth = 3;
                                                            ctx.stroke();
                                                            ctx.restore();
                                                            if (point.$context.hover) {
                                                                requestAnimationFrame(pulseAnimation);
                                                            }
                                                        };

                                                        pulseAnimation();
                                                    }
                                                });
                                            }
                                        }]
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </section>
            </section>
        </section>
    </main>

    <script src="{{ asset('js/admin/adminMain.js') }}"></script>

@endsection
