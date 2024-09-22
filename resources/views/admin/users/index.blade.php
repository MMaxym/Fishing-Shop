@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1200px;">
        <div class="d-flex justify-content-between align-items-center mb-4" >
            <h1 class="mb-0">Користувачі</h1>
            <a href="{{ url('/admin') }}" class="btn btn-outline-secondary">Повернутися на головну <-</a>
        </div>

        <div class="row mb-3">
            <div class="col-md-8">
                <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Додати нового користувача
                </a>
            </div>
            <div class="col-md-4">
                <div class="input-group"  style="width: 300px; margin-left: auto;">
                    <input type="text" class="form-control" id="search" placeholder="Пошук за логіном">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div id="no-results" class="alert alert-info" style="display: none;  text-align: center;">
            Користувачів не знайдено.
        </div>

        <table class="table table-bordered" style="background-color: #ffffff;">
            <thead>
            <tr>
                <th>Логін</th>
                <th>Прізвище</th>
                <th>Імʼя</th>
                <th>Електронна пошта</th>
                <th>Телефон</th>
                <th>Адреса</th>
                <th>Роль</th>
                <th style="width: 105px;">Дії</th>
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

                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $user->login }}')">
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
            fetchUsers(query);
        });

        function fetchUsers(query) {
            fetch(`{{ route('admin.users.search') }}?query=${encodeURIComponent(query)}`)
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
                    </td>
`;
                            tableBody.appendChild(row);
                        });
                    }
                });
        }

        function confirmDelete(login) {
            return confirm(`Ви точно бажаєте видалити користувача з логіном "${login}"?`);
        }
    </script>
@endsection
