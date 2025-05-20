@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/editProfile.css') }}">
    <title>Fishing Store</title>
</head>

@section('content')

    @include('layouts.header-user')

    <main class="main-section">
        <section class="main-row" id="main-row-product-details">
            <div class="main-row-wrapper">
                <nav aria-label="breadcrumb" class="page-navigation">
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item">
                            <a href="{{ route('user.main') }}">
                                <img src="{{ asset('images/v2/icon/HomeFilled.svg') }}" alt="Home Icon">
                                Головна
                            </a>
                            <span class="breadcrumb-separator">
                                <img src="{{ asset('images/v2/icon/ArrowSmallRightNav.svg') }}" alt="Arrow Icon">
                            </span>
                        </li>
                        @auth
                            <li class="current-product"> Особистий кабінет користувача {{ Auth::user()->surname }} {{ Auth::user()->name }}</li>
                        @else
                            <li class="current-product"> Особистий кабінет користувача</li>
                        @endauth
                    </ul>
                </nav>
            </div>
        </section>

        <section class="main-row">
            <div class="nav-section">
                <nav class="navigate-category">
                    <a href="{{route('user.main')}}" class="navigate-link" id="navigate-link-content-top">
                        <div class="navigate-link-content" id="navigate-link-content-top">
                            <img src="{{ asset('images/v2/icon/HomeOutlineEditProfile.svg') }}" alt="Новинки" class="navigate-icon">
                            <span class="navigate-text">Головна</span>
                        </div>
                    </a>
                    <a href="{{route('user.main')}}" class="navigate-link">
                        <div class="navigate-link-content">
                            <img src="{{ asset('images/v2/icon/LikeOutlineEditPorfile.svg') }}" alt="Акційні товари" class="navigate-icon">
                            <span class="navigate-text">Улюблені</span>
                        </div>
                    </a>
                    <a href="{{route('user.shoppingCart')}}" class="navigate-link">
                        <div class="navigate-link-content">
                            <img src="{{ asset('images/v2/icon/BasketOutlineEditProfile.svg') }}" alt="Балансири" class="navigate-icon">
                            <span class="navigate-text">Кошик</span>
                        </div>
                    </a>
                    <a href="{{route('user.orderHistory')}}" class="navigate-link">
                        <div class="navigate-link-content">
                            <img src="{{ asset('images/v2/icon/HistoryEditProfile.svg') }}" alt="Балансири" class="navigate-icon">
                            <span class="navigate-text">Історія замовлень</span>
                        </div>
                    </a>
                    <a href="{{route('user.editProfile')}}" class="navigate-link active">
                        <div class="navigate-link-content">
                            <img src="{{ asset('images/v2/icon/SettingFilledEditProfile.svg') }}" alt="Тейл-спінери" class="navigate-icon" style="width: 28px; height: 28px;">
                            <span class="navigate-text">Особистий кабінет</span>
                        </div>
                    </a>
                    <a href="#" class="navigate-link" id="logout-link">
                        <div class="navigate-link-content">
                            <img src="{{ asset('images/v2/icon/LogOutOutlineEditProfile.svg') }}" alt="Вийти" class="navigate-icon">
                            <span class="navigate-text">Вийти з акаунту</span>
                        </div>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </nav>
            </div>

            <section class="slider-section">
                @auth
                    <h3 class="edit-info-title">Особистий кабінет</h3>
                    <div class="edit-info">
                        <form action="{{ route('user.update', Auth::user()->id) }}" method="POST" class="form-login">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="email" class="label-field">Електронна пошта</label>
                                <input type="email" class="input-field" id="email" name="email" value="{{ old('email', Auth::user()->email) }}">
                                @error('email')
                                <div class="input-error">* {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="login" class="label-field">Логін</label>
                                <input type="text" class="input-field" id="login" name="login" value="{{ old('login', Auth::user()->login) }}">
                                @error('login')
                                <div class="input-error">* {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group-row">
                                <div class="form-group-column">
                                    <label for="surname" class="label-field">Прізвище</label>
                                    <input type="text" class="input-field" id="surname" name="surname" value="{{ old('surname', Auth::user()->surname) }}">
                                    @error('surname')
                                    <div class="input-error">* {{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group-column">
                                    <label for="name" class="label-field">Імʼя</label>
                                    <input type="text" class="input-field" id="name" name="name" value="{{ old('name', Auth::user()->name) }}">
                                    @error('name')
                                    <div class="input-error">* {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="label-field">Телефон</label>
                                <div class="password-wrapper">
                                   <input type="tel" class="input-field" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
                                </div>
                                @error('full_phone')
                                <div class="input-error">* {{ $message }}</div>
                                @enderror
                            </div>
                            <input type="hidden" name="full_phone" id="full_phone">

                            <div class="form-group">
                                <label for="address" class="label-field">Адреса</label>
                                <input type="text" class="input-field" id="address" name="address" value="{{ old('address', Auth::user()->address) }}">
                                @error('address')
                                <div class="input-error">* {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn-login">Зберегти зміни</button>
                            </div>
                        </form>
                    </div>
                @else
                    <h3 class="edit-info-title">Особистий кабінет</h3>
                    <div class="edit-info">
                        <form class="form-login">
                            <div class="form-group">
                                <label for="email" class="label-field">Електронна пошта</label>
                                <input type="email" class="input-field" id="email" value="Данні не знайдено" disabled>
                            </div>

                            <div class="form-group">
                                <label for="login" class="label-field">Логін</label>
                                <input type="text" class="input-field" id="login" value="Данні не знайдено" disabled>
                            </div>

                            <div class="form-group">
                                <label for="surname" class="label-field">Прізвище</label>
                                <input type="text" class="input-field" id="surname" value="Данні не знайдено" disabled>
                            </div>

                            <div class="form-group">
                                <label for="name" class="label-field">Імʼя</label>
                                <input type="text" class="input-field" id="name" value="Данні не знайдено" disabled>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="label-field">Телефон</label>
                                <input type="tel" class="input-field" id="phone" value="Данні не знайдено" disabled>
                            </div>

                            <div class="form-group">
                                <label for="address" class="label-field">Адреса</label>
                                <input type="text" class="input-field" id="address" value="Данні не знайдено" disabled>
                            </div>
                        </form>
                    </div>
                @endauth
            </section>
        </section>
    </main>

    @include('layouts.footer-user')

    <script src="{{ asset('js/user/editProfile.js') }}"></script>

@endsection
