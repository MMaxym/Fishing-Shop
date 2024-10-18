@extends('layouts.app')

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
                <style>
                    body {
                        background-image: url('{{ asset('images/log-reg-background.png') }}');
                        background-attachment: fixed;
                        background-size: cover;
                        background-position: center;
                        min-height: 100vh;
                    }

                    #btn-update-password {
                        background-color: #2C73BB;
                        width: 100%;
                        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
                        border-radius: 5px;
                        color: white;
                    }

                    #btn-update-password:hover {
                        background-color: #266198;
                        color: white;
                    }

                    a {
                        text-decoration: none;
                        font-size: 14px;
                    }

                    a:hover {
                        text-decoration: none;
                        color: #c53727;
                    }

                    #logBack {
                        text-decoration: none;
                        font-size: 14px;
                    }

                    #logBack:hover {
                        text-decoration: none;
                        color: #c53727;
                    }

                    p {
                        text-decoration: none;
                        font-size: 14px;
                        color: #666;
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

                    .input-group .toggle-password-confirmation {
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

                    .toggle-password-confirmation i {
                        color: #dc3545;
                    }

                    .toggle-password-confirmation i.fa-eye-slash {
                        color: #555555;
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

                    document.querySelector('.toggle-password-confirmation').addEventListener('click', function() {
                        const passwordConfirmationField = document.getElementById('password_confirmation');
                        const passwordFieldType = passwordConfirmationField.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordConfirmationField.setAttribute('type', passwordFieldType);

                        const icon = this.querySelector('i');
                        icon.classList.toggle('fa-eye-slash');
                        icon.classList.toggle('fa-eye');
                    });

                </script>

            </div>
        </div>
    </div>
@endsection
