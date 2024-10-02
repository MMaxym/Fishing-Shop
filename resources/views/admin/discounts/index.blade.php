@extends('layouts.app')

@section('content')
    @include('layouts.heder-admin')
    <div class="container" style="max-width: 1000px; margin-top: 130px;">
        <div class="d-flex justify-content-left align-items-center mb-4">
            <h1 class="mb-0">Знижки</h1>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('admin.discounts.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Додати нову знижку
            </a>
            <a href="" class="btn btn-dark me-2" style="width: auto; margin-right: 570px; white-space: nowrap;">
                <i class="fas fa-file-alt"></i> Сформувати звіт
            </a>
        </div>

        <div class="d-flex justify-content-between mb-4">
            <div>
                <label for="discount-type-filter" class="form-label">Фільтр за типом знижки</label>
                <div class="input-group" style="width: 250px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-tags"></i>
                        </span>
                    </div>
                    <select id="discount-type-filter" class="form-control">
                        <option value="">Усі знижки</option>
                        <option value="На товар" {{ request('filter_type') == 'На товар' ? 'selected' : '' }}>На товар</option>
                        <option value="На замовлення" {{ request('filter_type') == 'На замовлення' ? 'selected' : '' }}>На замовлення</option>
                    </select>
                    <div class="input-group-append">
                        <button id="reset-type-filter" class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <label for="discount-status-filter" class="form-label">Фільтр за статусом знижки</label>
                <div class="input-group" style="width: 280px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-check-circle"></i>
                        </span>
                    </div>
                    <select id="discount-status-filter" class="form-control">
                        <option value="">Усі знижки</option>
                        <option value="active" {{ request('filter_status') == 'active' ? 'selected' : '' }}>Діючі знижки</option>
                        <option value="expired" {{ request('filter_status') == 'expired' ? 'selected' : '' }}>Завершені знижки</option>
                    </select>
                    <div class="input-group-append">
                        <button id="reset-status-filter" class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <div class="input-group" style="width: 300px; margin-top: 31px;">
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
            Знижки не знайдено.
        </div>

        <div class="table-responsive" style="max-height: 535px; overflow-y: auto;">
            <table class="table table-bordered" style="background-color: #ffffff;">
                <thead class="thead-light">
                <tr>
                    <th style="min-width: 150px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(0)">
                        Назва <i id="sortIcon0" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 100px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(1)">
                        Відсоток <i id="sortIcon1" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 150px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(2)">
                        Дата початку <i id="sortIcon2" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 150px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(3)">
                        Дата завершення <i id="sortIcon3" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 100px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(4)">
                        Тип <i id="sortIcon4" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 105px; position: sticky; top: 0; z-index: 1;">
                        Дії
                    </th>
                </tr>
                </thead>
                <tbody id="discount-table-body">
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
    </div>

    <script>
        function fetchDiscounts(query = '', filterType = '', filterStatus = '') {
            fetch(`{{ route('admin.discounts.filter') }}?query=${encodeURIComponent(query)}&filter_type=${encodeURIComponent(filterType)}&filter_status=${encodeURIComponent(filterStatus)}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('discount-table-body');
                    const noResults = document.getElementById('no-results');
                    tableBody.innerHTML = '';

                    if (data.discounts.length === 0) {
                        noResults.style.display = 'block';
                    } else {
                        noResults.style.display = 'none';
                        data.discounts.forEach(discount => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                        <td>${discount.name}</td>
                        <td>${discount.percentage}%</td>
                        <td>${new Date(discount.start_date).toISOString().slice(0, 10)}</td>
                        <td>${new Date(discount.end_date).toISOString().slice(0, 10)}</td>
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
                })
                .catch(error => {
                    console.error('Error fetching discounts:', error);
                });
        }

        document.getElementById('reset-type-filter').addEventListener('click', function() {
            document.getElementById('discount-type-filter').value = '';
            const query = document.getElementById('search').value;
            const filterStatus = document.getElementById('discount-status-filter').value;
            fetchDiscounts(query, '', filterStatus);
        });

        document.getElementById('reset-status-filter').addEventListener('click', function() {
            document.getElementById('discount-status-filter').value = '';
            const query = document.getElementById('search').value;
            const filterType = document.getElementById('discount-type-filter').value;
            fetchDiscounts(query, filterType, '');
        });

        document.getElementById('search').addEventListener('input', function() {
            const query = this.value;
            fetchDiscounts(query, document.getElementById('discount-type-filter').value, document.getElementById('discount-status-filter').value);
        });

        document.getElementById('discount-type-filter').addEventListener('change', function() {
            const query = document.getElementById('search').value;
            const filterType = this.value;
            fetchDiscounts(query, filterType, document.getElementById('discount-status-filter').value);
        });

        document.getElementById('discount-status-filter').addEventListener('change', function() {
            const query = document.getElementById('search').value;
            const filterStatus = this.value;
            fetchDiscounts(query, document.getElementById('discount-type-filter').value, filterStatus);
        });

        function confirmDelete(discountName) {
            return confirm(`Ви дійсно хочете видалити знижку "${discountName}"?`);
        }

        let sortOrder = {};

        function sortTable(columnIndex) {
            const table = document.getElementById("discount-table-body");
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
            for (let i = 0; i < 5; i++) {
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
