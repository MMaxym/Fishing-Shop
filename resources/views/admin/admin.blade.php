@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1600px;">
        @include('layouts.header-admin')

        <div style="margin-top: 150px; margin-bottom: 50px;">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="row mt-6">
                        <div class="col-md-12">
                            <div class="card text-white mb-4 shadow" style="background-color: #2C73BB;">
                                <div class="card-header">
                                    <i class="fas fa-users"></i> Користувачі
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Управління користувачами <i class="fas fa-user-cog"></i>
                                    </h5>
                                    <p class="card-text"> Додавайте, редагуйте або видаляйте користувачів системи.</p>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-light" style="margin-top: 27px;">
                                        Перейти <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card text-white bg-secondary mb-4 shadow">
                                <div class="card-header">
                                    <i class="fas fa-box"></i> Товари
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Управління товарами <i class="fas fa-box-open"></i>
                                    </h5>
                                    <p class="card-text">Додавайте, редагуйте або видаляйте товари.</p>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-light" style="margin-top: 27px;">
                                        Перейти <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card text-white mb-4 shadow" style="background-color: #2C73BB;">
                                <div class="card-header">
                                    <i class="fas fa-shopping-cart"></i> Замовлення
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Управління замовленнями <i class="fas fa-clipboard-list"></i>
                                    </h5>
                                    <p class="card-text">Переглядайте та обробляйте інформацію про замовлення.
                                    </p>
                                    <a href="{{ route('admin.orders.index') }}" class="btn btn-light" style="margin-top: 27px;">
                                        Перейти <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card text-white bg-secondary mb-4 shadow">
                                <div class="card-header">
                                    <i class="fas fa-percent"></i> Знижки
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Управління знижками <i class="fas fa-tags"></i>
                                    </h5>
                                    <p class="card-text">Переглядайте та обробляйте інформацію про знижки.
                                    </p>
                                    <a href="{{ route('admin.discounts.index') }}" class="btn btn-light" style="margin-top: 28px;">
                                        Перейти <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="card mb-4 shadow" style="height: 300px; margin-bottom: 20px;">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Нові замовлення за сьогодні ({{ now()->format('d.m.Y') }})</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group" style="max-height: 200px; overflow-y: auto;">
                                @if($newOrders->isEmpty() || !$newOrders->contains(function ($order) {
                                    return $order->status === 'В обробці' && \Carbon\Carbon::parse($order->created_at)->isToday();
                                }))
                                    <li class="list-group-item text-center">
                                        <em>Нових замовлень за сьогодні немає.</em>
                                    </li>
                                @else
                                    @foreach($newOrders as $order)
                                        @if($order->status === 'В обробці' && \Carbon\Carbon::parse($order->created_at)->isToday())
                                            <li class="list-group-item d-flex justify-content-between align-items-center border-bottom">
                                                <div>
                                                    <strong>Замовлення:</strong> #{{ $order->id }}
                                                    <span class="mx-2">|</span>
                                                    <strong>Статус:</strong> {{ $order->status }}
                                                    <span class="mx-2">|</span>
                                                    <strong>Створено:</strong> {{ $order->created_at->format('d.m.Y H:i') }}
                                                </div>
                                                <a href="{{ route('admin.orders.products', $order->id) }}"
                                                   class="btn btn-info btn-sm">
                                                    <i class="fas fa-list-ul"></i>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-14">
{{--                        <div class="card mb-3 shadow" style="height: 573px;">--}}
                        <div class="card mb-3 shadow" style="height: min-content;">
                            <div class="card-header text-white" style="background-color: #04396E;">
                                <h5 class="mb-0">Аналітика інтернет-магазину</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card text-white bg-success mb-3 shadow">
                                            <div class="card-body text-center">
                                                <h5 class="card-title"><i class="fas fa-shopping-cart"></i> Кількість замовлень</h5>
                                                <p class="card-text" style="font-size: 24px;">{{ $orderCountLastMonth ?? 0 }}</p>
                                                <small>За останній місяць</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card text-white bg-success mb-3 shadow">
                                            <div class="card-body text-center">
                                                <h5 class="card-title"><i class="fas fa-dollar-sign"></i> Загальна сума продажів</h5>
                                                <p class="card-text" style="font-size: 24px;">{{ number_format($totalSalesLastMonth ?? 0, 2) }} грн</p>
                                                <small>За останній місяць</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card text-white bg-success mb-3 shadow">
                                            <div class="card-body text-center">
                                                <h5 class="card-title"><i class="fas fa-user-plus"></i> Нові клієнти в магазині</h5>
                                                <p class="card-text" style="font-size: 24px;">{{ $newCustomersLastMonth ?? 0 }}</p>
                                                <small>За останній місяць</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="graphic"></div>
                                    <h4 style="margin-top: 30px;">Динаміка прибутку інтернет-магазину (за останні 12 місяців)</h4>
                                    <canvas id="graphic" width="400" height="200"></canvas>
                                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            var ctx = document.getElementById('graphic').getContext('2d');
                                            var chart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: @json($categories),
                                                    datasets: [{
                                                        label: 'Динаміка прибутку',
                                                        data: @json($quantities),
                                                        borderColor: '#2C73BB',
                                                        borderWidth: 3,
                                                        fill: false
                                                    }]
                                                },
                                                options: {
                                                    responsive: true,
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true
                                                        }
                                                    }
                                                }
                                            });
                                        });
                                    </script>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
        }

        .card:hover {
            transform: scale(1.05);
        }
    </style>

@endsection
