@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <title>Fishing Store</title>
</head>

@section('content')

    <div class="main-container">
        <a href="{{ route('user.main') }}" class="logo-link">
            <img class="logo-icon" alt="Logo" title="Перейти на головну" src="{{ asset('images/v2/img/logo.svg') }}">
        </a>
        <div class="content">
            <section class="section-login">
                <h2 class="title-login">Вхід в акаунт</h2>

                <form id="form-login" action="{{ route('login') }}" method="POST" class="form-login">
                    @csrf

{{--                    @if ($errors->any())--}}
{{--                        <div class="cancel-parent">--}}
{{--                            <img class="icon-cancel" alt="Cancel" src="{{ asset('images/v2/icon/CanselOutline.svg') }}">--}}
{{--                            @foreach ($errors->all() as $error)--}}
{{--                                <span>{{ $error }}</span>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    @endif--}}

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

                    <a href="{{ route('password.request') }}" class="forgot-password">Забули пароль?</a>

                    <div class="buttons">
                        <button type="submit" class="btn-login">Увійти</button>

                        <div class="login-divider">
                            <div class="divider-line"></div>
                            <span class="divider-text">Або увійти за допомогою</span>
                            <div class="divider-line"></div>
                        </div>

                        <a class="btn-google" href="{{ route('google.redirect') }}">
                            <img class="google-icon" alt="Google" src="{{ asset('images/v2/icon/SocialGoogle.svg') }}">
                            <span class="btn-google-text">Google</span>
                        </a>

                        <div class="register-link">
                            <span class="text-link">У вас немає акаунта?</span>
                            <a href="{{ route('register') }}" id="r-link" class="r-link">Зареєструватися</a>
                        </div>
                    </div>
                </form>
            </section>

            <img class="background-img" alt="Login Image" src="{{ asset('images/v2/img/login-img.svg') }}">

        </div>
    </div>

    <script src="{{ asset('js/auth/login.js') }}"></script>

@endsection
