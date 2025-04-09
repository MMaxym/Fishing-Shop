@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/editProfile.css') }}">
    <title>Fishing Store - Персональний кабінет користувача</title>
</head>

@section('content')

    <div class="container" style="max-width: 1600px;">
        @include('layouts.header-user')
        <div class="form-card">
            <div class="form-container">
                @auth
                    <h3>Редагування персональної інформації користувача "{{ Auth::user()->surname }} {{ Auth::user()->name }}"</h3>

                    <form action="{{ route('user.update', Auth::user()->id) }}" method="POST">
                        @csrf
                        @method('PUT')
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
                            <label for="login">Логін</label>
                            <input type="text" class="form-control" id="login" name="login" value="{{ old('login', Auth::user()->login) }}" required>
                            @error('login')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="surname">Прізвище</label>
                            <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname', Auth::user()->surname) }}" required>
                            @error('surname')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Імʼя</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Електронна пошта</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Телефон</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" required style="width: 300px;">
                            @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Адреса</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', Auth::user()->address) }}">
                            @error('address')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Зберегти зміни
                            </button>
                            <a href="{{ route('user.main') }}" class="btn btn-outline-dark mx-3" id="back-button">
                                <i class="fas fa-arrow-left"></i> Назад
                            </a>
                        </div>
                    </form>
                @else
                    <h3>Редагування персональної інформації користувача: Користувач не авторизований</h3>

                    <form>
                        <div class="form-group">
                            <label for="login">Логін</label>
                            <input type="text" class="form-control" id="login" value="Данні не знайдено" disabled>
                        </div>

                        <div class="form-group">
                            <label for="surname">Прізвище</label>
                            <input type="text" class="form-control" id="surname" value="Данні не знайдено" disabled>
                        </div>

                        <div class="form-group">
                            <label for="name">Імʼя</label>
                            <input type="text" class="form-control" id="name" value="Данні не знайдено" disabled>
                        </div>

                        <div class="form-group">
                            <label for="email">Електронна пошта</label>
                            <input type="email" class="form-control" id="email" value="Данні не знайдено" disabled>
                        </div>

                        <div class="form-group">
                            <label for="phone">Телефон</label>
                            <input type="tel" class="form-control" id="phone" value="Данні не знайдено" disabled style="width: 300px;">
                        </div>

                        <div class="form-group">
                            <label for="address">Адреса</label>
                            <input type="text" class="form-control" id="address" value="Данні не знайдено" disabled>
                        </div>
                    </form>
                @endauth
            </div>
        </div>

        <div id="scrollToTop" class="scroll-to-top">
            <i class="fas fa-arrow-up"></i>
        </div>
    </div>

    @include('layouts.footer-user')

    <script src="{{ asset('js/user/editProfile.js') }}"></script>


@endsection
