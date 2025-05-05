<head>
    <link rel="stylesheet" href="{{ asset('css/header-user.css') }}">
</head>

<header class="header-user">
    <div class="logo-section">
        <a href="{{ route('user.main') }}" class="logo-link">
            <img class="logo-icon" alt="Logo" title="Перейти на головну" src="{{ asset('images/v2/img/logo.svg') }}">
        </a>
    </div>

    <div class="search-section">
        <form action="{{ route('search') }}" method="GET" class="search-form">
            <button type="submit" class="search-btn">
                <img src="{{ asset('images/v2/icon/Search.svg') }}" alt="Пошук" id="search-icon" class="search-icon">
            </button>
            <input type="text" name="query" class="search-input" placeholder="Пошук за назвою . . .">
        </form>
    </div>

    <div class="info-pages">
        <ul class="pages-links">
            <li class="nav-item">
                <a href="{{ route('user.main') }}" class="nav-link {{ request()->routeIs('user.main') ? 'active' : '' }}">Головна</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.about') }}" class="nav-link {{ request()->routeIs('user.about') ? 'active' : '' }}">Про нас</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.discount') }}" class="nav-link {{ request()->routeIs('user.discount') ? 'active' : '' }}">Знижки</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.delivery') }}" class="nav-link {{ request()->routeIs('user.delivery') ? 'active' : '' }}">Доставка</a>
            </li>
        </ul>
    </div>

    <div class="user-pages">
        @auth
            <a href="{{ route('user.main') }}" class="link-icon">
                <img class="user-page-icon" alt="Logo" title="Перейти на сторінку Улюблені товари" src="{{ asset('images/v2/icon/LikeFilledHeader.svg') }}">
            </a>
            <a href="{{ route('user.shoppingCart') }}" class="link-icon position-relative">
                <div class="shopping-cart-icon">
                    <img class="user-page-cart-icon" alt="Logo" title="Перейти на сторінку Кошик" src="{{ asset('images/v2/icon/BasketFilledHeader.svg') }}">
                    @php
                        $cart = session('cart', []);
                        $cartCount = count($cart);
                    @endphp
                    <span class="cart-badge">{{ $cartCount }}</span>
                </div>
            </a>
            <a href="{{ route('user.orderHistory') }}" class="link-icon">
                <img class="user-page-icon" alt="Logo" title="Перейти на сторінку Історія замовлень" src="{{ asset('images/v2/icon/HistoryHeader.svg') }}">
            </a>
            <a href="{{ route('user.editProfile') }}" class="link-icon">
                <img class="user-page-icon" alt="Logo" title="Перейти на сторінку Персональний кабінет" src="{{ asset('images/v2/icon/UserAllFilledHeader.svg') }}">
            </a>
        @endauth

        @guest
            <button class="btn-link-login" onclick="window.location.href='{{ route('login') }}'">Увійти</button>
        @endguest

    </div>

    <script src="{{ asset('js/header-user.js') }}"></script>

</header>
