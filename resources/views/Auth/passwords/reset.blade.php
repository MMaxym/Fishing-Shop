@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/auth/reset.css') }}">
    <title>Fishing Store</title>
</head>

@section('content')

    <div class="main-container">
        <a href="{{ route('user.main') }}" class="logo-link">
            <img class="logo-icon" alt="Logo" title="Перейти на головну" src="{{ asset('images/v2/img/logo.svg') }}">
        </a>
        <div class="content">
            <section class="section-login">
                <h2 class="title-login">Оновлення пароля</h2>

                <form id="form-login" action="{{ route('password.update') }}" method="POST" class="form-login">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label for="email" class="label-field">Електронна пошта</label>
                        <input type="email" id="email" name="email" class="input-field" value="{{ old('email') }}" placeholder="Введіть email . . ." >
                        @error('email')
                        <div class="input-error">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="label-field">Пароль</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" class="input-field" placeholder="Введіть пароль . . .">
                            <img src="{{ asset('images/v2/icon/PasswordYes.svg') }}" alt="Показати пароль" id="toggle-password" class="toggle-password-icon">
                        </div>
                        @error('password')
                        <div class="input-error">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="label-field">Підтвердження пароля</label>
                        <div class="password-wrapper">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="input-field" placeholder="Введіть пароль ще раз . . .">
                            <img src="{{ asset('images/v2/icon/PasswordYes.svg') }}" alt="Показати пароль" id="toggle-password-confirm" class="toggle-password-confirm-icon">
                        </div>
                        @error('password_confirmation')
                        <div class="input-error">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="buttons">
                        <button type="submit" class="btn-login">Зберегти новий пароль</button>

                        <div class="register-link">
                            <span class="text-link">Згадали пароль?</span>
                            <a href="{{ route('register') }}" id="r-link" class="r-link">Увійти</a>
                        </div>
                    </div>
                </form>
            </section>

            <img class="background-img" alt="Login Image" src="{{ asset('images/v2/img/new-password-img.svg') }}">

        </div>
    </div>

    <script src="{{ asset('js/auth/reset.js') }}"></script>

@endsection
