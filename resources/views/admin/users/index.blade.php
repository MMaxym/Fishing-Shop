@extends('layouts.app')

@section('content')
    @include('layouts.header-admin')
    <div class="container" style="max-width: 1400px; margin-top: 110px;">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h1 class="mb-0">Користувачі</h1>
        </div>
        <div class="row align-items-end mb-4 g-2 flex-wrap">
            <div class="col-auto">
                <a href="{{ route('admin.users.create') }}" class="btn btn-success" style="height: 100%;">
                    <i class="fas fa-plus"></i> Додати нового користувача
                </a>
            </div>

            <div class="col-auto">
                <a href="{{ route('pdf.export') }}" id="pdf" class="btn btn-primary">
                    <i class="fas fa-file-alt"></i> Сформувати звіт в .pdf
                </a>
            </div>

            <div class="col-auto">
                <a href="{{ route('admin.users.excelExport', request()->all()) }}" class="btn btn-secondary">
                    <i class="fas fa-file-excel"></i> Експортувати дані в .xlsx
                </a>
            </div>

            <div class="col-auto">
                <label for="role-filter" class="form-label mb-1">Тип користувача</label>
                <div class="input-group" style="width: max-content;">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-filter"></i>
                        </span>
                    </div>
                    <select id="role-filter" class="form-control">
                            <option value="">Усі користувачі</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    <div class="input-group-append">
                        <button id="reset-filter" class="btn btn-secondary" type="button">
                                <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-auto ms-auto">
                <div class="input-group" style="width: 240px; margin-left: auto;">
                    <input type="text" class="form-control" id="search" placeholder="Пошук за логіном">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div id="no-results" class="alert alert-info" style="display: none; text-align: center;">
            Користувачів не знайдено.
        </div>

        <div class="table-responsive" style="max-height: 580px; overflow-y: auto;">
            <table class="table table-bordered" style="background-color: #ffffff;">
                <thead class="thead-light">
                <tr>
                    <th style="min-width: 120px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(0)">
                        Логін <i id="sortIcon0" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 150px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(1)">
                        Прізвище <i id="sortIcon1" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 150px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(2)">
                        Імʼя <i id="sortIcon2" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 200px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(3)">
                        Електронна пошта <i id="sortIcon3" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 100px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(4)">
                        Телефон <i id="sortIcon4" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 200px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(5)">
                        Адреса <i id="sortIcon5" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 100px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(6)">
                        Роль <i id="sortIcon6" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 105px; position: sticky; top: 0; z-index: 1;">
                        Дії
                    </th>
                </tr>
                </thead>
                <tbody id="user-table-body">
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->login }}</td>
                        <td>{{ $user->surname }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                  style="display:inline;" onsubmit="return confirmDelete('{{ $user->login }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px;">
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
            background-color: #2C73BB;
            color: white;
            border: 1px solid #2C73BB;
        }

        #pdf:hover{
            background-color: #235b93;
        }
    </style>

    <script>
        document.getElementById('search').addEventListener('input', function () {
            const query = document.getElementById('search').value;
            const role = document.getElementById('role-filter').value;
            fetchUsers(query, role);
        });

        document.getElementById('role-filter').addEventListener('change', function () {
            const query = document.getElementById('search').value;
            const role = document.getElementById('role-filter').value;
            fetchUsers(query, role);
        });

        document.getElementById('reset-filter').addEventListener('click', function () {
            document.getElementById('search').value = '';
            document.getElementById('role-filter').value = '';

            fetchUsers('', '');
        });

        function fetchUsers(query, role) {
            fetch(`{{ route('admin.users.filter') }}?query=${encodeURIComponent(query)}&role=${encodeURIComponent(role)}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('user-table-body');
                    const noResults = document.getElementById('no-results');
                    tableBody.innerHTML = '';

                    if (data.users.length === 0) {
                        noResults.style.display = 'block';
                    } else {
                        noResults.style.display = 'none';
                        data.users.forEach(user => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                        <td>${user.login}</td>
                        <td>${user.surname}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.phone}</td>
                        <td>${user.address}</td>
                        <td>${user.role.name}</td>
                        <td>
                            <a href="/admin/users/${user.id}/edit" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/admin/users/${user.id}" method="POST" style="display:inline;" onsubmit="return confirmDelete('${user.login}')">
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

        function confirmDelete(login) {
            return confirm(`Ви точно бажаєте видалити користувача з логіном "${login}"?`);
        }

        let sortOrder = {};

        function sortTable(columnIndex) {
            const table = document.getElementById("user-table-body");
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
            for (let i = 0; i < 7; i++) {
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
