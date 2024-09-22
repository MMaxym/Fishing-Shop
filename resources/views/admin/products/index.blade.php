@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1500px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Товари</h1>
            <a href="{{ url('/admin') }}" class="btn btn-outline-secondary">Повернутися на головну <-</a>
        </div>

        <div class="row mb-3">
            <div class="col-md-8">
                <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Додати новий товар
                </a>
            </div>
            <div class="col-md-4">
                <div class="input-group" style="width: 300px; margin-left: auto;">
                    <input type="text" class="form-control" id="search" placeholder="Пошук за назвою">
                    <div class="input-group-append">
                <span class="input-group-text">
                    <i class="fas fa-search"></i>
                </span>
                    </div>
                </div>
            </div>
        </div>

        <div id="no-results" class="alert alert-info" style="display: none; text-align: center;">
            Товарів не знайдено.
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" style="background-color: #ffffff;">
                <thead>
                <tr>
                    <th>Артикул</th>
                    <th>Назва</th>
                    <th>Категорія</th>
                    <th>Опис</th>
                    <th>Розмір</th>
                    <th>Інше</th>
                    <th>Кількість</th>
                    <th>Ціна</th>
                    <th>Знижка</th>
                    <th>Статус</th>
                    <th>Зображення</th>
                    <th style="width: 50px;">Дії</th>

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
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->discount ? $product->discount->percentage . '%' : 'Немає' }}</td>
                        <td>{{ $product->is_active ? 'Активний' : 'Неактивний' }}</td>
                        <td style="width: 140px; white-space: nowrap;">
                            <div class="btn-group-vertical" role="group">
                                <a href="{{ route('admin.products.images.add', $product->id) }}" class="btn btn-success btn-sm mb-2">
                                    <i class="fas fa-plus"></i> Додати
                                </a>
                                <a href="{{ route('admin.products.images.edit', $product->id) }}" class="btn btn-primary btn-sm mb-2">
                                    <i class="fas fa-edit"></i> Редагувати
                                </a>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $product->name }}')">
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

    <script>
        document.getElementById('search').addEventListener('input', function() {
            const query = document.getElementById('search').value;
            fetchProducts(query);
        });

        function fetchProducts(query) {
            fetch(`{{ route('admin.products.search') }}?query=${encodeURIComponent(query)}`, {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Мережевий запит не був успішним');
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
                    <td>${product.price}</td>
                    <td>${product.discount ? product.discount.percentage + '%' : 'Немає'}</td>
                    <td>${product.is_active ? 'Активний' : 'Неактивний'}</td>
                    <td style="width: 100px; white-space: nowrap;">
                        <a href="/admin/products/${product.id}/edit" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="/admin/products/${product.id}" method="POST" style="display:inline;" onsubmit="return confirmDelete('${product.name}')">
                            <input type="hidden" name="_method" value="DELETE">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                    <td style="width: 150px;">
                        <div class="btn-group-vertical" role="group">
                            <a href="/admin/products/${product.id}/images/add" class="btn btn-success btn-sm mb-2">
                                <i class="fas fa-plus"></i> Додати
                            </a>
                            <a href="/admin/products/${product.id}/images/edit" class="btn btn-primary btn-sm mb-2">
                                <i class="fas fa-edit"></i> Редагувати
                            </a>
                        </div>
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

        function confirmDelete(name) {
            return confirm(`Ви точно бажаєте видалити товар з назвою "${name}"?`);
        }

        function confirmDelete(id) {
            return confirm(`Ви точно бажаєте видалити зображення з ідентифікатором "${id}"?`);
        }

    </script>
@endsection
