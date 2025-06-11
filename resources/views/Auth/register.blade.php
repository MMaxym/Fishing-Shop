@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
    <title>Fishing Store</title>
</head>

@section('content')
    <div class="main-container">
        <a href="{{ route('user.main') }}" class="logo-link">
            <img class="logo-icon" alt="Logo" title="Перейти на головну" src="{{ asset('images/v2/img/logo.svg') }}">
        </a>
        <div class="content">
            <img class="background-img" alt="Login Image" src="{{ asset('images/v2/img/login-img.svg') }}">

            <section class="section-login">
                <h2 class="title-login">Реєстрація</h2>

                <form id="form-login" action="{{ route('register') }}" method="POST" class="form-login">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="label-field">Електронна пошта</label>
                        <input type="email" id="email" name="email" class="input-field" value="{{ old('email') }}" placeholder="Введіть email . . ." >
                        @error('email')
                        <div class="input-error">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group-row">
                        <div class="form-group-column">
                            <label for="password" class="label-field">Пароль</label>
                            <div class="password-wrapper">
                                <input type="password" id="password" name="password" class="input-field" placeholder="Введіть пароль . . .">
                                <img src="{{ asset('images/v2/icon/PasswordYes.svg') }}" alt="Показати пароль" id="toggle-password" class="toggle-password-icon">
                            </div>
                            @error('password')
                            <div class="input-error">* {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group-column">
                            <label for="password" class="label-field" id="password_confirmation_desktop">Підтвердження пароля</label>
                            <label for="password" class="label-field" id="password_confirmation_mobile">Пароль ще раз</label>
                            <div class="password-wrapper">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="input-field" placeholder="Повторіть пароль . . ." style="padding-right: 40px;">
                                <img src="{{ asset('images/v2/icon/PasswordYes.svg') }}" alt="Показати пароль" id="toggle-password-confirm" class="toggle-password-confirm-icon">
                            </div>
                            @error('password_confirmation')
                            <div class="input-error">* {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="login" class="label-field">Логін</label>
                        <input type="text" id="login" name="login" class="input-field" value="{{ old('login') }}" placeholder="Введіть логін . . ." >
                        @error('login')
                        <div class="input-error">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group-row">
                        <div class="form-group-column">
                            <label for="surname" class="label-field">Прізвище</label>
                            <div class="password-wrapper">
                                <input type="text" id="surname" name="surname" class="input-field" value="{{ old('surname') }}" placeholder="Введіть прізвище . . .">
                            </div>
                            @error('surname')
                            <div class="input-error">* {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group-column">
                            <label for="name" class="label-field">Імʼя</label>
                            <div class="password-wrapper">
                                <input type="text" id="name" name="name" class="input-field" value="{{ old('name') }}" placeholder="Введіть імʼя . . .">
                            </div>
                            @error('name')
                            <div class="input-error">* {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="label-field">Телефон</label>
                        <div class="password-wrapper">
                            <input type="tel" id="phone" name="phone" class="input-field" value="{{ old('phone') }}" placeholder="Введіть телефон . . ." />
                        </div>
                        @error('full_phone')
                        <div class="input-error">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address" class="label-field">Адреса</label>
                        <div class="password-wrapper">
                            <input type="text" id="address" name="address" class="input-field" value="{{ old('address') }}" placeholder="Введіть адресу . . .">
                        </div>
                        @error('address')
                        <div class="input-error">* {{ $message }}</div>
                        @enderror
                    </div>

                    <input type="hidden" name="full_phone" id="full_phone">

                    <div class="buttons">
                        <button type="submit" class="btn-login">Зареєструватися</button>

                        <div class="register-link">
                            <span class="text-link">Вже маєте акаунт?</span>
                            <a href="{{ route('login') }}" id="r-link" class="r-link">Увійти</a>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>

    <script src="{{ asset('js/auth/register.js') }}"></script>

@endsection
