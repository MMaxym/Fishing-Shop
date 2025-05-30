@extends('layouts.app')

@section('content')
    @include('layouts.header-admin')
    <div class="container" style="max-width: 1550px; margin-top: 110px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">Товари</h1>
        </div>

        <div class="row mb-3" style="padding: 0;">
            <div class="col-md-12 d-flex align-items-center">
                <a href="{{ route('admin.products.create') }}" class="btn btn-success me-2" style="width: max-content; white-space: nowrap;">
                    <i class="fas fa-plus"></i> Додати новий товар
                </a>
                <a href="{{ route('pdf.export.product') }}" class="btn me-2" id="pdf" style="width: max-content; margin-left: 30px;">
                    <i class="fas fa-file-alt"></i> Сформувати звіт в .pdf
                </a>
                <a href="{{ route('admin.products.export', request()->all()) }}" class="btn btn-secondary me-2" style="width: max-content; margin-left: 30px;  white-space: nowrap;">
                    <i class="fas fa-file-alt"></i> Експортувати дані в .xslx
                </a>
                <div class="ms-auto" style="width: 300px; margin-left: 482px;">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" placeholder="Пошук за назвою">
                        <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap mb-4" style="max-width: 1550px; gap: 5rem;">
            <div class="d-flex flex-column flex-grow-1" style="min-width: 250px;">
                <label for="category-filter" class="form-label">Фільтр за категорією</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-tags"></i>
                        </span>
                    </div>
                    <select id="category-filter" class="form-control">
                        <option value="">Усі категорії</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button id="reset-category-filter" class="btn btn-secondary" type="button">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-grow-1" style="min-width: 250px; max-width: 400px;">
                <label for="price-filter" class="form-label">Фільтр за ціною</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-dollar-sign"></i>
                    </span>
                    </div>
                    <input type="number" id="price-min" class="form-control" placeholder="Мін. ціна">
                    <input type="number" id="price-max" class="form-control" placeholder="Макс. ціна">
                    <div class="input-group-append">
                        <button id="reset-price-filter" class="btn btn-secondary" type="button">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-grow-1" style="min-width: 250px;">
                <label for="status-filter" class="form-label">Фільтр за статусом</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-check-circle"></i>
                    </span>
                    </div>
                    <select id="status-filter" class="form-control">
                        <option value="">Усі товари</option>
                        <option value="active">Активні</option>
                        <option value="inactive">Неактивні</option>
                    </select>
                    <div class="input-group-append">
                        <button id="reset-status-filter" class="btn btn-secondary" type="button">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-grow-1" style="min-width: 250px; max-width: 250px;">
                <label for="quantity-filter" class="form-label">Фільтр за кількістю</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-sort-numeric-up"></i>
                    </span>
                    </div>
                    <input type="number" id="quantity-filter" class="form-control" placeholder="Макс. кількість">
                    <div class="input-group-append">
                        <button id="reset-quantity-filter" class="btn btn-secondary" type="button">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="no-results" class="alert alert-info" style="display: none; text-align: center;">
            Товарів не знайдено.
        </div>

        <div class="table-responsive" style="max-height: 515px; overflow-y: auto;">
            <table class="table table-bordered" style="background-color: #ffffff;">
                <thead class="thead-light">
                <tr>
                    <th style="min-width: 110px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(0)">
                        Артикул <i id="sortIcon0" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 150px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(1)">
                        Назва <i id="sortIcon1" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 130px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(2)">
                        Категорія <i id="sortIcon2" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 200px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(3)">
                        Опис <i id="sortIcon3" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 100px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(4)">
                        Розмір <i id="sortIcon4" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 100px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(5)">
                        Інше <i id="sortIcon5" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 120px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(6)">
                        Кількість <i id="sortIcon6" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 90px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(7)">
                        Ціна <i id="sortIcon7" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 120px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(8)">
                        Знижка <i id="sortIcon8" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 100px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(9)">
                        Статус <i id="sortIcon9" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 100px; position: sticky; top: 0; z-index: 1;">
                        Зображення
                    </th>
                    <th style="width: 50px; max-width: 50px; position: sticky; top: 0; z-index: 1;">
                        Дії
                    </th>

                </tr>
                </thead>
                <tbody id="product-table-body">
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->article }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->size }}</td>
                        <td>{{ $product->other }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ number_format($product->price, 0, ',', ' ') }} грн</td>
                        <td>{{ $product->discount ? $product->discount->percentage . '%' : 'Немає' }}</td>
                        <td>{{ $product->is_active ? 'Активний' : 'Неактивний' }}</td>
                        <td style="width: 140px; white-space: nowrap;">
                            <div class="btn-group-vertical" role="group">
                                <a href="{{ route('admin.products.images.add', $product->id) }}"
                                   class="btn btn-success btn-sm mb-2">
                                    <i class="fas fa-plus"></i> Додати
                                </a>
                                <a href="{{ route('admin.products.images.edit', $product->id) }}"
                                   class="btn btn-warning btn-sm mb-2">
                                    <i class="fas fa-edit"></i> Редагувати
                                </a>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                  style="display:inline;"
                                  onsubmit="return confirmDeleteProduct('{{ $product->name }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        #pdf{
            width: 220px;
            margin-left: 20px;
            white-space: nowrap;
            background-color: #2C73BB;
            color: white;
            z-index:1000;
        }

        #pdf:hover{
            background-color: #235b93;
        }

        #product-table-body tr:hover {
            background-color: #f1f1f1;
            transition: background-color 0.2s ease;
            cursor: pointer;
        }
    </style>

    <script>
        document.getElementById('search').addEventListener('input', function () {
            const query = document.getElementById('search').value;
            fetchProducts(query);
        });

        document.getElementById('category-filter').addEventListener('change', function () {
            fetchProducts(document.getElementById('search').value);
        });

        document.getElementById('price-min').addEventListener('input', function () {
            fetchProducts(document.getElementById('search').value);
        });

        document.getElementById('price-max').addEventListener('input', function () {
            fetchProducts(document.getElementById('search').value);
        });

        document.getElementById('status-filter').addEventListener('change', function () {
            fetchProducts(document.getElementById('search').value);
        });

        document.getElementById('quantity-filter').addEventListener('input', function () {
            fetchProducts(document.getElementById('search').value);
        });

        document.getElementById('reset-category-filter').addEventListener('click', function () {
            document.getElementById('category-filter').value = '';
            fetchProducts();
        });

        document.getElementById('reset-price-filter').addEventListener('click', function () {
            document.getElementById('price-min').value = '';
            document.getElementById('price-max').value = '';
            fetchProducts();
        });

        document.getElementById('reset-status-filter').addEventListener('click', function () {
            document.getElementById('status-filter').value = '';
            fetchProducts();
        });

        document.getElementById('reset-quantity-filter').addEventListener('click', function () {
            document.getElementById('quantity-filter').value = '';
            fetchProducts();
        });

        function numberFormat2(number, decimals = 0, dec_point = '.', thousands_sep = ',') {
            number = parseFloat(number);
            if (!isFinite(number)) return '0';

            return number.toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, thousands_sep);
        }

        function fetchProducts(query = '') {
            const category = document.getElementById('category-filter').value;
            const priceMin = document.getElementById('price-min').value;
            const priceMax = document.getElementById('price-max').value;
            const status = document.getElementById('status-filter').value;
            const quantity = document.getElementById('quantity-filter').value;

            const url = `{{ route('admin.products.filter') }}?query=${encodeURIComponent(query)}&category=${category}&price_min=${priceMin}&price_max=${priceMax}&status=${status}&quantity=${quantity}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Мережевий запит не був успішним !!!');
                    }
                    return response.json();
                })
                .then(data => {
                    const tableBody = document.getElementById('product-table-body');
                    const noResults = document.getElementById('no-results');
                    tableBody.innerHTML = '';

                    if (data.products.length === 0) {
                        noResults.style.display = 'block';
                    } else {
                        noResults.style.display = 'none';
                        data.products.forEach(product => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                        <td>${product.article}</td>
                        <td>${product.name}</td>
                        <td>${product.category.name}</td>
                        <td>${product.description}</td>
                        <td>${product.size}</td>
                        <td>${product.other}</td>
                        <td>${product.quantity}</td>
                        <td>${numberFormat2(product.price, 0, ',', ' ') + ' грн'}</td>
                        <td>${product.discount ? product.discount.percentage + '%' : 'Немає'}</td>
                        <td>${product.is_active ? 'Активний' : 'Неактивний'}</td>
                        <td style="width: 140px; white-space: nowrap;">
                            <div class="btn-group-vertical" role="group">
                                <a href="/admin/products/${product.id}/images/add" class="btn btn-success btn-sm mb-2">
                                    <i class="fas fa-plus"></i> Додати
                                </a>
                                <a href="/admin/products/${product.id}/images/edit" class="btn btn-warning btn-sm mb-2">
                                    <i class="fas fa-edit"></i> Редагувати
                                </a>
                            </div>
                        </td>
                        <td style="width: 50px; max-width:50px; white-space: nowrap;">
                            <a href="/admin/products/${product.id}/edit" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/admin/products/${product.id}" method="POST" onsubmit="return confirmDeleteProduct('${product.name}')">
                                <input type="hidden" name="_method" value="DELETE">
                                @csrf
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

        function confirmDeleteProduct(name) {
            return confirm(`Ви точно бажаєте видалити товар з назвою "${name}"?`);
        }

        let sortOrder = {};

        function sortTable(columnIndex) {
            const table = document.getElementById("product-table-body");
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
            for (let i = 0; i < 10; i++) {
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


