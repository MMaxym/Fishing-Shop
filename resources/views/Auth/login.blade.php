@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <title>Fishing Store - Авторизація</title>
</head>

@section('content')
    <div class="container" style="max-width: 400px; margin: 0 auto; padding-bottom: 30px; margin-top: 120px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5); margin-top: 130px;">
            <div class="card-header" style="background-color: #becfff;">
                <h2>Вхід в акаунт</h2>
            </div>
            <div class="card-body" style="padding-bottom: 10px;">
                <form action="{{ route('login') }}" method="POST">
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
                        <label for="email">Електронна пошта</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        @error('email')
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

                    <div>
                        <a href="{{ route('password.request') }}" class="btn btn-link">Забули пароль?</a>
                    </div>

                    <button type="submit" class="btn-login">Увійти</button>

                    <div class="divider" style="margin-bottom: 5px; margin-top: 15px;">Або</div>


                    <div class="btn-google" style="margin-top: 10px;">
                        <a href="{{ route('google.redirect') }}" class="google-btn-link">
                            <img src="{{ asset('images/Google.svg') }}" alt="Google Icon" class="google-icon">
                            Продовжити через Google
                        </a>
                    </div>

                    <div style="margin-top: 20px; text-align: center;">
                        <p>У Вас немає акаунта? <a href="{{ route('register') }}">Зареєструватися</a></p>
                    </div>
                </form>
                <script src="{{ asset('js/auth/login.js') }}"></script>
            </div>
        </div>
    </div>
@endsection
