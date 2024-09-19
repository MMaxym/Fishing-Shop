@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1400px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Products</h1>
            <a href="{{ url('/admin') }}" class="btn btn-outline-secondary">Back to main page <-</a>
        </div>

        <div class="row mb-3">
            <div class="col-md-8">
                <a href="{{ route('admin.products.create') }}" class="btn btn-success">Add New Product +</a>
            </div>
            <div class="col-md-4">
                <div class="input-group" style="width: 300px; margin-left: auto;">
                    <input type="text" class="form-control" id="search" placeholder="Search by name">
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
                    <th>Article</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Size</th>
                    <th>Other</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Images</th>
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
                        <td>{{ $product->is_active ? 'Active' : 'Inactive' }}</td>
                        <td style="width: 100px; white-space: nowrap;">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $product->name }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                        <td style="width: 150px; white-space: nowrap;">
                            <div class="btn-group-vertical" role="group">
                                <a href="{{ route('admin.products.images.add', $product->id) }}" class="btn btn-success btn-sm mb-2">
                                    <i class="fas fa-plus"></i> Add Image
                                </a>
                                <a href="{{ route('admin.products.images.edit', $product->id) }}" class="btn btn-primary btn-sm mb-2">
                                    <i class="fas fa-edit"></i> Edit Images
                                </a>
                                @foreach($product->images as $image)
                                    <form action="{{ route('admin.products.images.delete', ['product' => $product->id, 'images' => $image->id]) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $image->id }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm mb-2">
                                            <i class="fas fa-trash"></i> Del Image {{ $image->id }}
                                        </button>
                                    </form>
                                @endforeach


                            </div>
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
                        throw new Error('Network response was not ok');
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
                    <td>${product.is_active ? 'Active' : 'Inactive'}</td>
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
                                <i class="fas fa-plus"></i> Add Image
                            </a>
                            <a href="/admin/products/${product.id}/images/edit" class="btn btn-primary btn-sm mb-2">
                                <i class="fas fa-edit"></i> Edit Images
                            </a>
                            <a href="/admin/products/${product.id}/images/delete" class="btn btn-danger btn-sm mb-2">
                                <i class="fas fa-trash"></i> Del Images
                            </a>
                        </div>
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


        function confirmDelete(name) {
            return confirm(`Ви точно бажаєте видалити користувача з назвою "${name}"?`);
        }

        function confirmDelete(id) {
            return confirm(`Ви точно бажаєте видалити зображення з ідентифікатором "${id}"?`);
        }

    </script>
@endsection
