@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1600px;">
        @include('layouts.header-admin')

        <div style="margin-top: 150px; margin-bottom: 50px;">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="row mt-6">
                        <div class="col-md-12">
                            <div class="card text-white bg-secondary mb-3 shadow">
                                <div class="card-header">Користувачі</div>
                                <div class="card-body">
                                    <h5 class="card-title">Управління користувачами</h5>
                                    <p class="card-text">Додавайте, редагуйте або видаляйте користувачів системи.</p>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-light">Перейти</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card text-white bg-primary mb-3 shadow">
                                <div class="card-header">Товари</div>
                                <div class="card-body">
                                    <h5 class="card-title">Управління товарами</h5>
                                    <p class="card-text">Додавайте, редагуйте або видаляйте товари.</p>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-light">Перейти</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card text-white bg-success mb-3 shadow">
                                <div class="card-header">Замовлення</div>
                                <div class="card-body">
                                    <h5 class="card-title">Управління замовленнями</h5>
                                    <p class="card-text">Переглядайте та обробляйте інформацію про замовлення.</p>
                                    <a href="{{ route('admin.orders.index') }}" class="btn btn-light">Перейти</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card text-white bg-danger mb-3 shadow">
                                <div class="card-header">Знижки</div>
                                <div class="card-body">
                                    <h5 class="card-title">Управління знижками</h5>
                                    <p class="card-text">Переглядайте та обробляйте інформацію про знижки.</p>
                                    <a href="{{ route('admin.discounts.index') }}" class="btn btn-light">Перейти</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-3 shadow" style="height: 450px;">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Нові замовлення за сьогодні ({{ now()->format('d.m.Y') }})</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
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
                        <div class="card mb-3 shadow" style="height: 450px;">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0">Календар подій</h5>
                            </div>
                            <div class="card-body">
                                <div id="calendar"></div>
                                <div>ТУТ ЗРОБИТИ ЯКИЙСЬ КОНТЕНТ, ТИПУ КАЛЕНДАР АБО ЩОСЬ ІНШЕ ЦІКАВЕ</div>
                                <div>МОЖЛИВО ЯКУСЬ АНАЛІТИКУ, ТИПУ КІЛЬКІСТЬ ЗАМОВЛЕНЬ ЗА ОСТАННІЙ МІСЯЦЬ, ЗАГАЛЬНИЙ
                                    ПРИБУТОК І Т.Д.

                                    графік якої категорії скільки товарів продалося за останній місяць

                                    додати іконки на карточки переходу на адмінці
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
