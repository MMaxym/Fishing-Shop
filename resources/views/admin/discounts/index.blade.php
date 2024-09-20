@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1000px;">
            <div class="d-flex justify-content-between align-items-center mb-4" >
                <h1 class="mb-0">Discounts</h1>
                <a href="{{ url('/admin') }}" class="btn btn-outline-secondary">Back to main page <-</a>
            </div>
            <div class="row mb-3">
                <div class="col-md-8">
                    <a href="{{ route('admin.discounts.create') }}" class="btn btn-success mb-3">Add Discount +</a>
                </div>
                <div class="col-md-4">
                    <div class="input-group"  style="width: 300px; margin-left: auto;">
                        <input type="text" class="form-control" id="search" placeholder="Search by name">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="no-results" class="alert alert-info" style="display: none;  text-align: center;">
                Знижки не знайдено.
            </div>

            <table class="table table-bordered" style="background-color: #ffffff;">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Percentage</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($discounts as $discount)
                    <tr>
                        <td>{{ $discount->name }}</td>
                        <td>{{ $discount->percentage }}%</td>
                        <td>{{ $discount->start_date->format('Y-m-d') }}</td>
                        <td>{{ $discount->end_date->format('Y-m-d') }}</td>
                        <td>{{ $discount->type }}</td>
                        <td>
                            <a href="{{ route('admin.discounts.edit', $discount) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.discounts.destroy', $discount) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $discount->name }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px">
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
            const query = document.getElementById('search').value;
            fetchDiscounts(query);
        });

        function fetchDiscounts(query) {
            fetch(`{{ route('admin.discounts.search') }}?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('tbody');
                    const noResults = document.getElementById('no-results');
                    tableBody.innerHTML = '';

                    if (data.discounts.length === 0) {
                        noResults.style.display = 'block';
                    } else {
                        noResults.style.display = 'none';
                        data.discounts.forEach(discount => {
                            const startDate = new Date(discount.start_date).toISOString().slice(0, 10);
                            const endDate = new Date(discount.end_date).toISOString().slice(0, 10);

                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${discount.name}</td>
                                <td>${discount.percentage}%</td>
                                <td>${startDate}</td>
                                <td>${endDate}</td>
                                <td>${discount.type}</td>
                                <td>
                                    <a href="/admin/discounts/${discount.id}/edit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/admin/discounts/${discount.id}" method="POST" style="display:inline;" onsubmit="return confirmDelete('${discount.name}')">
                                        <input type="hidden" name="_method" value="DELETE">
                                        @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                    </form>
                                </td>`;
                            tableBody.appendChild(row);
                        });

                    }
                });
        }

        function confirmDelete(name) {
            return confirm(`Ви точно бажаєте видалити знижку "${name}"?`);
        }
    </script>


@endsection
