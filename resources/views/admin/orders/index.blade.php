@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1600px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Замовлення</h1>
            <a href="{{ url('/admin') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Повернутися на головну
            </a>
        </div>

        <div class="row mb-3">
            <div class="col-md-8">
                <a href="{{ route('admin.orders.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Додати нове замовлення
                </a>
            </div>
            <div class="col-md-4">
                <div class="input-group" style="width: 300px; margin-left: auto;">
                    <input type="text" class="form-control" id="search" placeholder="Пошук за № замовлення">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div id="no-results" class="alert alert-info" style="display: none; text-align: center;">
            Замовлень не знайдено.
        </div>

        <table class="table table-bordered" style="background-color: #ffffff;">
            <thead>
            <tr>
                <th>№ Замовлення</th>
                <th>Користувач</th>
                <th>Метод оплати</th>
                <th>Метод доставки</th>
                <th>Знижка</th>
                <th>Адреса</th>
                <th>Сума</th>
                <th>Статус</th>
                <th>Замовлення створено</th>
                <th style="width: 70px;">Усі товари</th>
                <th style="width: 50px;">Дії</th>
            </tr>
            </thead>
            <tbody id="order-table-body">
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user ? $order->user->login : 'Користувача не знайдено' }}</td>
                    <td>{{ $order->paymentMethod ? $order->paymentMethod->name : 'Метод не знайдено' }}</td>
                    <td>{{ $order->shippingMethod ? $order->shippingMethod->name : 'Метод доставки не знайдено' }}</td>
                    <td>{{ $order->discount_id ? ($order->discount ? $order->discount->percentage . '%' : 'Немає') : 'Немає' }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ number_format($order->total_amount, 2) . ' грн' }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td style="text-align: center;">
                        <a href="{{ route('admin.orders.products', $order->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-list-ul"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $order->id }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById('search').addEventListener('input', function() {
            const query = this.value.trim();
            if (query === '' || /^\d{0,6}$/.test(query)) {
                fetchOrders(query);
            } else {
                alert('Невірний формат № замовлення. Введіть лише числа.');
            }
        });

        function fetchOrders(query) {
            fetch(`/admin/orders/search?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('order-table-body');
                    const noResults = document.getElementById('no-results');
                    tableBody.innerHTML = '';

                    if (data.orders.length === 0) {
                        noResults.style.display = 'block';
                    } else {
                        noResults.style.display = 'none';
                        data.orders.forEach(order => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                        <td>${order.id}</td>
                        <td>${order.user ? order.user.login : 'Користувача не знайдено'}</td>
                        <td>${order.paymentMethod ? order.paymentMethod.name : 'Метод не знайдено'}</td>
                        <td>${order.shippingMethod ? order.shippingMethod.name : 'Метод доставки не знайдено'}</td>
                        <td>${order.discount_id ? (order.discount ? order.discount.percentage + '%' : 'Без знижки') : 'Без знижки'}</td>
                        <td>${order.address}</td>
                        <td>${parseFloat(order.total_amount).toFixed(2) + ' грн'}</td>
                        <td>${order.status}</td>
                        <td>${order.created_at}</td>
                        <td>
                            <a href="/admin/orders/${order.id}/edit" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/admin/orders/${order.id}" method="POST" style="display:inline;" onsubmit="return confirmDelete('${order.id}')">
                                <input type="hidden" name="_method" value="DELETE">
                                @csrf
                            <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
`;
                            tableBody.appendChild(row);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }


        function confirmDelete(id) {
            return confirm(`Ви точно бажаєте видалити замовлення з №${id}?`);
        }
    </script>
@endsection
