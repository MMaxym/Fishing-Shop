@extends('layouts.app')

@section('content')
    @include('layouts.header-admin')
    <div class="container" style="max-width: 1600px; margin-top: 110px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">Замовлення</h1>
        </div>

        <div class="row mb-3">
            <div class="col-md-8">
                <a href="{{ route('admin.orders.create') }}" class="btn btn-success" style="width: max-content; white-space: nowrap;">
                    <i class="fas fa-plus"></i> Додати нове замовлення
                </a>
                <a href="#" class="btn me-2" id="pdf-export-btn" style="width: max-content; white-space: nowrap;">
                    <i class="fas fa-file-alt"></i> Сформувати звіт в .pdf
                </a>
                <a href="{{ route('admin.orders.excelExport', request()->all()) }}" class="btn btn-secondary me-2" style="width: max-content;  margin-left: 20px; white-space: nowrap;">
                    <i class="fas fa-file-alt"></i> Експортувати дані в .xslx
                </a>
            </div>
            <div class="col-md-4">
                <div class="input-group" style="width: 300px; margin-left: auto;">
                    <input type="text" class="form-control" id="search" placeholder="Пошук за № замовлення"
                           onkeyup="searchOrders()">
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

        @if ($orders->isEmpty())
            <div class="alert alert-danger">
                <p>Жодних замовлень не знайдено!</p>
            </div>
        @else

            <div class="row mb-4 g-1" style="max-width: 1600px;">

                <div class="col">
                    <label for="status-filter" class="form-label">Фільтр за статусом</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                        </div>
                        <select id="status-filter" class="form-control">
                            <option value="">Усі замовлення</option>
                            <option value="В обробці">В обробці</option>
                            <option value="Очікує на оплату">Очікує на оплату</option>
                            <option value="Оплачено">Оплачено</option>
                            <option value="Доставлено">Доставлено</option>
                            <option value="Завершено">Завершено</option>
                            <option value="Скасовано">Скасовано</option>
                        </select>
                        <div class="input-group-append">
                            <button id="reset-status-filter" class="btn btn-secondary" type="button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="date-filter" class="form-label">Фільтр за датою замовлення</label>
                    <div class="input-group" style="width: 400px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                        <input type="date" id="date-from" class="form-control" placeholder="Від">
                        <input type="date" id="date-to" class="form-control" placeholder="До">
                        <div class="input-group-append">
                            <button id="reset-date-filter" class="btn btn-secondary" type="button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="payment-method-filter" class="form-label">Фільтр за методом оплати</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-tags"></i></span>
                        </div>
                        <select id="payment-method-filter" class="form-control">
                            <option value="">Усі методи</option>
                            @foreach ($paymentMethods as $paymentMethod)
                                <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button id="reset-payment-filter" class="btn btn-secondary" type="button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="shipping-method-filter" class="form-label">Фільтр за методом доставки</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-tags"></i></span>
                        </div>
                        <select id="shipping-method-filter" class="form-control">
                            <option value="">Усі методи</option>
                            @foreach ($shippingMethods as $shippingMethod)
                                <option value="{{ $shippingMethod->id }}">{{ $shippingMethod->name }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button id="reset-shipping-filter" class="btn btn-secondary" type="button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="discount-filter" class="form-label">Фільтр за знижкою</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-tags"></i></span>
                        </div>
                        <select id="discount-filter" class="form-control">
                            <option value="">Усі знижки</option>
                            <option value="null">Немає</option>
                            @foreach ($discounts->where('type', 'На замовлення')->unique('percentage')->sortBy('percentage') as $discount)
                                <option value="{{ $discount->id }}">{{ $discount->percentage }} %</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button id="reset-discount-filter" class="btn btn-secondary" type="button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>


            <div class="table-responsive" style="max-height: 520px; overflow-y: auto;">
                <table class="table table-bordered" style="background-color: #ffffff;">
                    <thead class="thead-light">
                    <tr>
                        <th style="min-width: 80px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                            onclick="sortTable(0)">
                            №<i id="sortIcon0" class="fas fa-sort"></i>
                        </th>
                        <th style="min-width: 140px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                            onclick="sortTable(1)">
                            Користувач <i id="sortIcon1" class="fas fa-sort"></i>
                        </th>
                        <th style="min-width: 160px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                            onclick="sortTable(2)">
                            Метод оплати <i id="sortIcon2" class="fas fa-sort"></i>
                        </th>
                        <th style="min-width: 180px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                            onclick="sortTable(3)">
                            Метод доставки <i id="sortIcon3" class="fas fa-sort"></i>
                        </th>
                        <th style="min-width: 110px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                            onclick="sortTable(4)">
                            Знижка <i id="sortIcon4" class="fas fa-sort"></i>
                        </th>
                        <th style="min-width: 110px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                            onclick="sortTable(5)">
                            Адреса <i id="sortIcon5" class="fas fa-sort"></i>
                        </th>
                        <th style="min-width: 110px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                            onclick="sortTable(6)">
                            Сума <i id="sortIcon6" class="fas fa-sort"></i>
                        </th>
                        <th style="min-width: 120px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                            onclick="sortTable(7)">
                            Статус <i id="sortIcon7" class="fas fa-sort"></i>
                        </th>
                        <th style="min-width: 230px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                            onclick="sortTable(8)">
                            Замовлення створено <i id="sortIcon8" class="fas fa-sort"></i>
                        </th>
                        <th style="min-width: 120px; position: sticky; top: 0; z-index: 1;">Усі товари</th>
                        <th style="min-width: 50px; position: sticky; top: 0; z-index: 1;">Дії</th>
                    </tr>
                    </thead>
                    <tbody id="order-table-body">
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>
                                {{ $order->user ? $order->user->surname . ' ' . $order->user->name . ' (' . $order->user->phone . ')' : 'Користувача не знайдено' }}
                            </td>
                            <td>{{ $order->paymentMethod ? $order->paymentMethod->name : 'Метод не знайдено' }}</td>
                            <td>{{ $order->shippingMethod ? $order->shippingMethod->name : 'Метод доставки не знайдено' }}</td>
                            <td>{{ $order->discount_id ? ($order->discount ? $order->discount->percentage . '%' : 'Немає') : 'Немає' }}</td>
                            <td>{{ $order->address }}</td>
                            <td>{{ number_format($order->total_amount, 0, ',', ' ') }} грн</td>
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

                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                      style="display:inline;" onsubmit="return confirmDelete('{{ $order->id }}')">
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
        @endif
    </div>

    <style>
        #pdf-export-btn{
            width: 220px;
            margin-left: 20px;
            white-space: nowrap;
            background-color: #2C73BB;
            color: white;
            z-index:1000;
        }

        #pdf-export-btn:hover{
            background-color: #235b93;
        }

        #order-table-body tr:hover {
            background-color: #f1f1f1;
            transition: background-color 0.2s ease;
            cursor: pointer;
        }
    </style>

    <script>
        function confirmDelete(id) {
            return confirm(`Ви точно бажаєте видалити замовлення з №${id}?`);
        }

        function searchOrders() {
            const searchValue = document.getElementById('search').value.toLowerCase();
            const orders = document.querySelectorAll('#order-table-body tr');
            let found = false;

            orders.forEach(order => {
                const orderNumber = order.querySelector('td:first-child').textContent;
                if (orderNumber.toLowerCase().includes(searchValue)) {
                    order.style.display = '';
                    found = true;
                } else {
                    order.style.display = 'none';
                }
            });

            document.getElementById('no-results').style.display = found ? 'none' : 'block';
        }

        document.getElementById('payment-method-filter').addEventListener('change', function () {
            fetchOrders(document.getElementById('search').value);
        });

        document.getElementById('shipping-method-filter').addEventListener('input', function () {
            fetchOrders(document.getElementById('search').value);
        });

        document.getElementById('discount-filter').addEventListener('input', function () {
            fetchOrders(document.getElementById('search').value);
        });

        document.getElementById('status-filter').addEventListener('change', function () {
            fetchOrders(document.getElementById('search').value);
        });

        document.getElementById('date-from').addEventListener('change', function () {
            fetchOrders(document.getElementById('search').value);
        });

        document.getElementById('date-to').addEventListener('change', function () {
            fetchOrders(document.getElementById('search').value);
        });

        document.getElementById('reset-date-filter').addEventListener('click', function () {
            document.getElementById('date-from').value = '';
            document.getElementById('date-to').value = '';
            fetchOrders();
        });

        document.getElementById('reset-status-filter').addEventListener('click', function () {
            document.getElementById('status-filter').value = '';
            fetchOrders();
        });

        document.getElementById('reset-discount-filter').addEventListener('click', function () {
            document.getElementById('discount-filter').value = '';
            fetchOrders();
        });

        document.getElementById('reset-payment-filter').addEventListener('click', function () {
            document.getElementById('payment-method-filter').value = '';
            fetchOrders();
        });

        document.getElementById('reset-shipping-filter').addEventListener('click', function () {
            document.getElementById('shipping-method-filter').value = '';
            fetchOrders();
        });

        function numberFormat2(number, decimals = 0, dec_point = '.', thousands_sep = ',') {
            number = parseFloat(number);
            if (!isFinite(number)) return '0';

            return number.toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, thousands_sep);
        }

        document.getElementById('pdf-export-btn').addEventListener('click', function () {
            const query = document.getElementById('search').value;
            const shippingMethod = document.getElementById('shipping-method-filter').value;
            const paymentMethod = document.getElementById('payment-method-filter').value;
            const discount = document.getElementById('discount-filter').value;
            const status = document.getElementById('status-filter').value;
            const dateFrom = document.getElementById('date-from').value;
            const dateTo = document.getElementById('date-to').value;

            const pdfUrl = `{{ route('pdf.export.orders') }}?query=${encodeURIComponent(query)}&shippingMethod=${shippingMethod}&paymentMethod=${paymentMethod}&discount=${discount}&status=${status}&dateFrom=${dateFrom}&dateTo=${dateTo}`;

            window.open(pdfUrl, '_blank');
        });

        function fetchOrders(query = '') {
            const shippingMethod = document.getElementById('shipping-method-filter').value;
            const paymentMethod = document.getElementById('payment-method-filter').value;
            const discount = document.getElementById('discount-filter').value;
            const status = document.getElementById('status-filter').value;
            const dateFrom = document.getElementById('date-from').value;
            const dateTo = document.getElementById('date-to').value;

            const url = `{{ route('admin.orders.filter') }}?query=${encodeURIComponent(query)}&shippingMethod=${shippingMethod}&paymentMethod=${paymentMethod}&discount=${discount}&status=${status}&dateFrom=${dateFrom}&dateTo=${dateTo}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Мережевий запит не був успішним');
                    }
                    return response.json();
                })
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
                            console.log(order);

                            row.innerHTML = `
                        <td>${order.id}</td>
                       <td> ${order.user ? order.user.login : 'Користувача не знайдено'}</td>
                        <td>${order.payment_method ? order.payment_method.name : 'Метод не знайдено'}</td>
                        <td>${order.shipping_method ? order.shipping_method.name : 'Метод доставки не знайдено' }</td>
                        <td>${order.discount ? order.discount.percentage + '%' : 'Немає'}</td>
                        <td>${order.address}</td>
                        <td>${numberFormat2(order.total_amount, 0, ',', ' ') + ' грн'}</td>
                        <td>${order.status}</td>
                        <td>${order.created_at.split('T')[0]+" "+ order.created_at.split('T')[1].substring(0,8)}</td>
                        <td style="text-align: center;">
                            <a href="/admin/orders/${order.id}/products" class="btn btn-info btn-sm">
                                <i class="fas fa-list-ul"></i>
                            </a>

                        </td>
                        <td>
                             <a href="/admin/orders/${order.id}/edit" class="btn btn-warning btn-sm mb-2">
                                <i class="fas fa-edit"></i>
                            </a>
                             <form action="/admin/orders/${order.id}" method="POST" onsubmit="return confirmDeleteProduct('${order.name}')">
                                @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px">
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
                    console.error('Помилка:', error);
                });
        }



        function numberFormat(number) {
            return new Intl.NumberFormat('uk-UA', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }).format(number);
        }



        let sortOrder = {};

        function sortTable(columnIndex) {
            const table = document.getElementById("order-table-body");
            const rows = Array.from(table.getElementsByTagName("tr"));

            let ascending = sortOrder[columnIndex] === "asc" ? false : true;
            sortOrder[columnIndex] = ascending ? "asc" : "desc";

            rows.sort((a, b) => {
                const cellA = a.getElementsByTagName("td")[columnIndex].innerText.toLowerCase();
                const cellB = b.getElementsByTagName("td")[columnIndex].innerText.toLowerCase();

                if (cellA < cellB) return ascending ? -1 : 1;
                if (cellA > cellB) return ascending ? 1 : -1;
                return 0;
            });

            while (table.firstChild) {
                table.removeChild(table.firstChild);
            }

            rows.forEach(row => table.appendChild(row));

            updateSortIcons(columnIndex, ascending);
        }

        function updateSortIcons(columnIndex, ascending) {
            for (let i = 0; i < 9; i++) {
                const icon = document.getElementById(`sortIcon${i}`);
                if (i === columnIndex) {
                    icon.className = ascending ? "fas fa-sort-up" : "fas fa-sort-down";
                } else {
                    icon.className = "fas fa-sort";
                }
            }
        }
    </script>
@endsection
