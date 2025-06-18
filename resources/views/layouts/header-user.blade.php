<head>
    <link rel="stylesheet" href="{{ asset('css/header-user.css') }}">
</head>


<header class="header-user">

    <div class="logo-section">
        <a href="{{ route('user.main') }}" class="logo-link">
            <img class="logo-icon" alt="Logo" title="Перейти на головну" src="{{ asset('images/v2/img/logo.svg') }}">
        </a>
    </div>

    <nav class="nav-mobile" id="mobileNav">
        <ul class="pages-links mobile">
            <li class="nav-item"><a href="{{ route('user.main') }}" class="nav-link {{ request()->routeIs('user.main') ? 'active' : '' }}" style="padding: 8px 7px;">Головна</a></li>
            <li class="nav-item"><a href="{{ route('user.about') }}" class="nav-link {{ request()->routeIs('user.about') ? 'active' : '' }}" style="padding: 8px 7px;">Про нас</a></li>
            <li class="nav-item"><a href="{{ route('user.discount') }}" class="nav-link {{ request()->routeIs('user.discount') ? 'active' : '' }}" style="padding: 8px 7px;">Знижки</a></li>
            <li class="nav-item"><a href="{{ route('user.delivery') }}" class="nav-link {{ request()->routeIs('user.delivery') ? 'active' : '' }}" style="padding: 8px 7px;">Доставка</a></li>
        </ul>

        <div class="user-pages mobile">
                <a class="pages-links-mobile-burger" href="{{ route('user.newProducts') }}">
                    <span class="link-content">
                        <img class="user-page-icon" src="{{ asset('images/v2/icon/NewOutlineLinlk.svg') }}">
                        Новинки
                    </span>
                    <img class="arrow-icon" src="{{ asset('images/v2/icon/ArrowSmallRight.svg') }}" alt="arrow">
                </a>

                <a class="pages-links-mobile-burger" href="{{ route('user.saleProducts') }}">
                    <span class="link-content">
                        <img class="user-page-icon" src="{{ asset('images/v2/icon/SaleOutlineLink.svg') }}">
                        Акційні товари
                    </span>
                    <img class="arrow-icon" src="{{ asset('images/v2/icon/ArrowSmallRight.svg') }}" alt="arrow">
                </a>

                <a class="pages-links-mobile-burger" href="{{ route('user.categoryBalancers') }}">
                        <span class="link-content">
                            <img class="user-page-icon" src="{{ asset('images/v2/icon/FishLink.svg') }}">
                            Балансири
                        </span>
                    <img class="arrow-icon" src="{{ asset('images/v2/icon/ArrowSmallRight.svg') }}" alt="arrow">
                </a>

                <a class="pages-links-mobile-burger" href="{{ route('user.categoryTailSpinners') }}">
                        <span class="link-content">
                            <img class="user-page-icon" src="{{ asset('images/v2/icon/FishLink.svg') }}">
                            Тейл-спінери
                        </span>
                    <img class="arrow-icon" src="{{ asset('images/v2/icon/ArrowSmallRight.svg') }}" alt="arrow">
                </a>

                <a class="pages-links-mobile-burger" href="{{ route('user.categoryPilkers') }}">
                        <span class="link-content">
                            <img class="user-page-icon" src="{{ asset('images/v2/icon/FishLink.svg') }}">
                            Пількери
                        </span>
                    <img class="arrow-icon" src="{{ asset('images/v2/icon/ArrowSmallRight.svg') }}" alt="arrow">
                </a>
        </div>


        <div class="user-pages mobile">
            @auth
                <a class="pages-links-mobile-burger" href="{{ route('user.orderHistory') }}">
            <span class="link-content">
                <img class="user-page-icon" src="{{ asset('images/v2/icon/HistoryHeader.svg') }}">
                Історія замовлень
            </span>
                    <img class="arrow-icon" src="{{ asset('images/v2/icon/ArrowSmallRight.svg') }}" alt="arrow">
                </a>
                <a class="pages-links-mobile-burger" href="{{ route('user.editProfile') }}">
            <span class="link-content">
                <img class="user-page-icon" src="{{ asset('images/v2/icon/UserAllFilledHeader.svg') }}">
                Особистий кабінет
            </span>
                    <img class="arrow-icon" src="{{ asset('images/v2/icon/ArrowSmallRight.svg') }}" alt="arrow">
                </a>
            @endauth
        </div>
    </nav>

    <div class="search-section">
        <form action="{{ route('search') }}" method="GET" class="search-form">
            <button type="submit" class="search-btn">
                <img src="{{ asset('images/v2/icon/Search.svg') }}" alt="Пошук" class="search-icon">
            </button>
            <input type="text" name="query" class="search-input" placeholder="Пошук за назвою . . .">
        </form>
    </div>

    @guest
        <button class="btn-link-login" id="btn-link-login-mobile" onclick="window.location.href='{{ route('login') }}'">Увійти</button>
        <button type="button" class="search-btn-mobile-only" id="searchToggleBtn">
            <img src="{{ asset('images/v2/icon/SearchMobile.svg') }}" alt="Пошук" class="search-icon-mobile-only">
        </button>
    @endguest

    <div class="search-section-mobile">
        <div class="search-overlay" id="searchOverlay">
            <div class="search-box">
                <form action="{{ route('search') }}" method="GET" class="search-form-mobile">
                    <button type="submit" class="search-btn-mobile">
                        <img src="{{ asset('images/v2/icon/Search.svg') }}" alt="Пошук" class="search-icon-mobile">
                    </button>
                    <input type="text" name="query" class="search-input-mobile" placeholder="Пошук за назвою . . .">
                </form>
                <button type="button" class="close-search" id="closeSearchBtn">&times;</button>
            </div>
        </div>
    </div>


    @auth
        <div class="user-pages-mobile-only">
            <button type="button" class="search-btn-mobile-only" id="searchToggleBtn">
                <img src="{{ asset('images/v2/icon/SearchMobile.svg') }}" alt="Пошук" class="search-icon-mobile-only">
            </button>
                <a href="{{ route('user.favoriteProducts') }}"><img class="user-page-icon" src="{{ asset('images/v2/icon/LikeFilledHeader.svg') }}"></a>
                <a href="{{ route('user.shoppingCart') }}" class="position-relative">
                    <div class="shopping-cart-icon">
                        <img class="user-page-cart-icon" src="{{ asset('images/v2/icon/BasketFilledHeader.svg') }}">
                        <span class="cart-badge">{{ count(session('cart', [])) }}</span>
                    </div>
                </a>
        </div>
    @endauth

    <button class="burger-menu" id="burgerMenu">
        <span class="burger-line"></span>
        <span class="burger-line"></span>
        <span class="burger-line"></span>
    </button>

    <div class="info-pages desktop">
        <ul class="pages-links">
            <li class="nav-item"><a href="{{ route('user.main') }}" class="nav-link {{ request()->routeIs('user.main') ? 'active' : '' }}">Головна</a></li>
            <li class="nav-item"><a href="{{ route('user.about') }}" class="nav-link {{ request()->routeIs('user.about') ? 'active' : '' }}">Про нас</a></li>
            <li class="nav-item"><a href="{{ route('user.discount') }}" class="nav-link {{ request()->routeIs('user.discount') ? 'active' : '' }}">Знижки</a></li>
            <li class="nav-item"><a href="{{ route('user.delivery') }}" class="nav-link {{ request()->routeIs('user.delivery') ? 'active' : '' }}">Доставка</a></li>
        </ul>
    </div>

    <div class="user-pages desktop">
        @auth
            <a href="{{ route('user.favoriteProducts') }}"><img class="user-page-icon" src="{{ asset('images/v2/icon/LikeFilledHeader.svg') }}"></a>
            <a href="{{ route('user.shoppingCart') }}" class="position-relative">
                <div class="shopping-cart-icon">
                    <img class="user-page-cart-icon" src="{{ asset('images/v2/icon/BasketFilledHeader.svg') }}">
                    <span class="cart-badge">{{ count(session('cart', [])) }}</span>
                </div>
            </a>
            <a href="{{ route('user.orderHistory') }}"><img class="user-page-icon" src="{{ asset('images/v2/icon/HistoryHeader.svg') }}"></a>
            <a href="{{ route('user.editProfile') }}"><img class="user-page-icon" src="{{ asset('images/v2/icon/UserAllFilledHeader.svg') }}"></a>
        @endauth

        @guest
            <button class="btn-link-login" onclick="window.location.href='{{ route('login') }}'">Увійти</button>
        @endguest
    </div>

    <script src="{{ asset('js/header-user.js') }}"></script>
</header>
