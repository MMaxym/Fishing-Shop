@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/auth/email.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <title>Fishing Store - Скидання пароля</title>
</head>

@section('content')
    <div class="container" style="max-width: 400px; margin: 0 auto; padding-bottom: 50px; margin-top: 190px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);">
            <div class="card-header" style="background-color: #becfff;">
                <h2>Скидання пароля</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
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
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <button type="submit" class="btn btn-email" id="btn-email">Надіслати посилання для скидання пароля</button>

                    <div style="margin-top: 20px; text-align: center;">
                        <p>Згадали пароль? <a href="{{ route('login') }}" id="logBack">Увійти</a></p>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

