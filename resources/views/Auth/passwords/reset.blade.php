@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/auth/reset.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <title>Fishing Store - Оновлення пароля</title>
</head>

@section('content')
    <div class="container" style="max-width: 400px; margin: 0 auto; padding-bottom: 50px; margin-top: 150px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);">
            <div class="card-header" style="background-color: #becfff;">
                <h2>Оновлення пароля</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

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
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Новий пароль</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required style="border-radius: 5px;">
                            <span class="toggle-password" style="cursor: pointer;">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        </div>
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Підтвердити новий пароль</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required style="border-radius: 5px;">
                            <span class="toggle-password-confirmation" style="cursor: pointer;">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        </div>
                        @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <button type="submit" class="btn btn-email" id="btn-update-password">Оновити пароль</button>

                    <div style="margin-top: 20px; text-align: center;">
                        <p>Згадали пароль? <a href="{{ route('login') }}" id="logBack">Увійти</a></p>
                    </div>
                </form>


                <script src="{{ asset('js/auth/reset.js') }}"></script>

            </div>
        </div>
    </div>
@endsection
