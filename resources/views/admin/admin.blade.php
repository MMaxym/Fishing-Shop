@extends('layouts.app')

@section('content')
    <div class="container">
        <header class="d-flex justify-content-between align-items-center mb-4 py-3 border-bottom">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mr-3" style="width: 50px; height: auto;">
                <h1 class="mb-0">Сторінка адміністратора</h1>
            </div>

            <nav>
                <ul class="nav">
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link btn btn-primary mx-3">Користувачі</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.products.index') }}" class="nav-link btn btn-primary mx-3">Товари</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.discounts.index') }}" class="nav-link btn btn-primary mx-3">Знижки</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.orders.index') }}" class="nav-link btn btn-primary mx-3">Замовлення</a>
                    </li>

                </ul>
            </nav>
        </header>

        <div class="jumbotron jumbotron-fluid bg-light" style="border-radius: 10px;">
            <div class="container">
                <h2 class="display-4" style="margin-bottom: 40px;">Вас вітає панель адміністратора!</h2>
                <p class="lead">Тут ви можете керувати користувачами, товарами, замовленнями та знижками вашого інтернет-магазину. Щоб почати, виберіть відповідний розділ у навігаційному меню.</p>
                <p>Якщо у вас виникли запитання чи проблеми, зверніться до нашої документації або зверніться до технічної підтримки.</p>
            </div>
        </div>
    </div>
@endsection
