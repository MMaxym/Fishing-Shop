@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 400px; margin: 0 auto; padding-bottom: 50px; margin-top: 190px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);">
            <div class="card-header" style="background-color: #d6d6d6;">
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
                        <input type="email" class="form-control" id="email" name="email" required autofocus>
                    </div>

                    <button type="submit" class="btn btn-email" id="btn-email">Надіслати посилання для скидання пароля</button>

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

                    #btn-email{
                        background-color: #2C73BB;
                        width: 100%;
                        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
                        border-radius: 5px;
                        color: white;
                    }

                    #btn-email:hover{
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

                    #logBack{
                        text-decoration: none;
                        font-size: 14px;
                    }

                    #logBack:hover{
                        text-decoration: none;
                        color: #c53727;
                    }

                    p {
                        text-decoration: none;
                        font-size: 14px;
                        color: #666;
                    }
                </style>
            </div>
        </div>
    </div>
@endsection

