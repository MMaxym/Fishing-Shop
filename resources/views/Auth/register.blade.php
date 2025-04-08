@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <title>Fishing Store - Реєстрація</title>
</head>

@section('content')
    <div class="container" style="max-width: 400px; margin: 0 auto; padding-bottom: 30px; margin-top: 120px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);">
            <div class="card-header" style="background-color: #becfff;">
                <h2>Реєстрація</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="login">Логін</label>
                        <input type="text" class="form-control" id="login" name="login" value="{{ old('login') }}" required>
                        @error('login')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required style="border-radius: 5px;">
                            <span class="toggle-password">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        </div>
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Підтвердити пароль</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required style="border-radius: 5px;">
                            <span class="toggle-password-confirmation">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        </div>
                        @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Електронна пошта</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="surname">Прізвище</label>
                        <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname') }}" required>
                        @error('surname')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Ім'я</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Телефон</label>
                        <div>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" style="width: 338px;">
                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Адреса</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                        @error('address')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-login">Зареєструватися</button>

                    <div style="margin-top: 20px; text-align: center;">
                        <p>Вже маєте акаунт? <a href="{{ route('login') }}">Увійти</a></p>
                    </div>
                </form>

                <script src="{{ asset('js/auth/register.js') }}"></script>

            </div>
        </div>
    </div>
@endsection
