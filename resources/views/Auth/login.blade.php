@extends('layouts.app')

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
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

                    <button type="submit" class="btn btn-login">Увійти</button>

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
                <style>
                    body {
                        background-image: url('{{ asset('images/log-reg-background.png') }}');
                        background-attachment: fixed;
                        background-size: cover;
                        background-position: center;
                        min-height: 100vh
                    }

                    .divider {
                        text-align: center;
                        margin: 20px 0;
                        position: relative;
                    }

                    .divider::before,
                    .divider::after {
                        content: '';
                        display: inline-block;
                        width: 38%;
                        height: 1px;
                        background-color: #b3b3b3;
                        vertical-align: middle;
                        margin: 0 10px;
                    }

                    .btn-google {
                        background-color: transparent;
                        border: 1.5px solid #2c73bb;
                        color: #2c73bb;
                        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
                        border-radius: 5px;
                        text-align: center;
                        padding: 3px 12px;
                        display: inline-block;
                        width: 100%;
                    }

                    .google-btn-link {
                        color: #2c73bb;
                        text-decoration: none;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 16px;
                    }

                    .google-btn-link:hover {
                        color: #2c73bb;
                    }

                    .btn-google:hover{
                        background-color: #e6f1ff;
                    }

                    .google-icon {
                        width: 29px;
                        height: 29px;
                        margin-right: 8px;
                        vertical-align: middle;
                    }

                    .form-group label {
                        font-weight: 500;
                        color: #666;
                    }

                    .form-control {
                        border: 1px solid #ddd;
                        border-radius: 5px;
                        padding: 12px;
                    }

                    .form-control:focus {
                        border-color: #2c73bb;
                        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
                    }

                    .input-group {
                        position: relative;
                    }

                    .input-group .toggle-password {
                        position: absolute;
                        right: 12px;
                        top: 50%;
                        transform: translateY(-50%);
                        cursor: pointer;
                    }

                    .toggle-password i {
                        color: #dc3545;
                    }

                    .toggle-password i.fa-eye-slash {
                        color: #555555;
                    }
                    a {
                        text-decoration: none;
                        font-size: 14px;
                        color: #2c73bb;
                    }

                    a:hover {
                        text-decoration: none;
                        color: #c53727;
                    }

                    p {
                        text-decoration: none;
                        font-size: 14px;
                        color: #666;
                    }

                    .btn-link{
                        text-decoration: none;
                        margin-top: 0;
                        margin-bottom: 10px;
                        color: #2c73bb;
                    }

                    .btn-link:hover{
                        text-decoration: none;
                        color: #c53727;
                    }

                    .btn-login{
                        background-color: #2C73BB;
                        width: 100%;
                        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
                        border-radius: 5px;
                        color: white;
                    }

                    .btn-login:hover{
                        background-color: #266198;
                        color: white;
                    }

                </style>
                <script>
                    document.querySelector('.toggle-password').addEventListener('click', function() {
                        const passwordField = document.getElementById('password');
                        const passwordFieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordField.setAttribute('type', passwordFieldType);

                        const icon = this.querySelector('i');
                        icon.classList.toggle('fa-eye-slash');
                        icon.classList.toggle('fa-eye');
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
