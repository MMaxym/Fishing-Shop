@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/auth/email.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <title>Fishing Store</title>
</head>

@section('content')

    <div class="main-container">
        <a href="{{ route('user.main') }}" class="logo-link">
            <img class="logo-icon" alt="Logo" title="Перейти на головну" src="{{ asset('images/v2/img/logo.svg') }}">
        </a>
        <div class="content">
            <section class="section-forgot">
                <h2 class="title-forgot">Скидання пароля</h2>

                <form id="form-forgot" action="{{ route('password.email') }}" method="POST" class="form-forgot">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="label-field">Електронна пошта</label>
                        <input type="email" id="email" name="email" class="input-field" value="{{ old('email') }}" placeholder="Введіть email . . ." >
                        @error('email')
                        <div class="input-error">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="buttons">
                        <button type="submit" class="btn-send">Надіслати посилання</button>

                        <div class="login-link">
                            <span class="text-link">Згадали пароль?</span>
                            <a href="{{ route('login') }}" id="r-link" class="r-link">Увійти</a>
                        </div>
                    </div>
                </form>
            </section>

            <img class="background-img" alt="Login Image" src="{{ asset('images/v2/img/forgot-password-img.svg') }}">

        </div>
    </div>

    <script src="{{ asset('js/auth/email.js') }}"></script>

@endsection

