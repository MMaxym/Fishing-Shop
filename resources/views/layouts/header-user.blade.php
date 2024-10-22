<head>
    <link rel="stylesheet" href="{{ asset('css/header-user.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<header class="header-style">
    <div class="d-flex align-items-center ml-4">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mr-3" style="width: 50px; height: auto;">
        <a href="{{ route('user.main') }}" class="mb-0" style="font-size: 28px; font-weight: 500; color: #04396E; text-decoration: none;">
            <h1 style="margin: 0; font-size: 28px;">Fishing Shop</h1>
        </a>
    </div>

    <div class="search-container d-flex align-items-center">
        <div class="position-relative w-100">
            <input type="text" class="form-control search-input" placeholder="Пошук за назвою">
            <i class="fa fa-search search-icon"></i>
        </div>
    </div>

    <nav class="d-flex align-items-center">
        <ul class="nav mx-auto">
            <li class="nav-item">
                <a href="{{ route('user.main') }}" class="nav-link highlighted mx-2 px-4 py-2 {{ request()->routeIs('user.main') ? 'active' : '' }}">Головна</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.about') }}" class="nav-link highlighted mx-2 px-4 py-2 {{ request()->routeIs('user.about') ? 'active' : '' }}">Про нас</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.discount') }}" class="nav-link highlighted mx-2 px-4 py-2 {{ request()->routeIs('user.discount') ? 'active' : '' }}">Знижки</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.delivery') }}" class="nav-link highlighted mx-2 px-4 py-2 {{ request()->routeIs('user.delivery') ? 'active' : '' }}">Доставка</a>
            </li>
        </ul>
    </nav>

    <div class="d-flex align-items-center mr-4">
        @auth
            <button class="btn p-0 mr-3" style="border: none; background: transparent;" onclick="window.location.href='{{ route('user.orderHistory') }}';">
                <i class="fas fa-history" style="font-size: 1.5rem; color: #04396E;"></i>
            </button>

            <button class="btn p-0 mr-3" style="border: none; background: transparent;">
                <i class="fas fa-shopping-cart" style="font-size: 1.5rem; color: #04396E; margin-left: 5px;"></i>
            </button>

            <div class="vr" style="height: 40px; width: 2px; background-color: #04396E; margin-left: 15px; margin-right: 25px;"></div>

            <div class="dropdown">
                <button class="btn p-0 mr-3" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="border: none; background: transparent;">
                    <i class="fas bi-person-circle" style="font-size: 2rem; color: #04396E;"></i>
                </button>
                <ul class="dropdown-menu custom-dropdown" aria-labelledby="dropdownMenuButton">
                    <li class="dropdown-header">
                        Профіль користувача
                    </li>
                    <li class="dropdown-item-user">
                        <strong>Імʼя:</strong> {{ Auth::user()->name }}
                    </li>
                    <li class="dropdown-item-user">
                        <strong>Прізвище:</strong> {{ Auth::user()->surname }}
                    </li>
                    <li class="dropdown-item-user">
                        <strong>Email:</strong> {{ Auth::user()->email }}
                    </li>
                    <li class="dropdown-item-user">
                        <strong>Логін:</strong> {{ Auth::user()->login }}
                    </li>
                    <li class="dropdown-item-user">
                        <strong>Телефон:</strong> {{ Auth::user()->phone }}
                    </li>
                    <li class="dropdown-item-user">
                        <strong>Адреса:</strong> {{ Auth::user()->address }}
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('user.editProfile')}}">
                            <i class="fas fa-edit"></i> Відредагувати профіль
                        </a>
                    </li>
                </ul>
            </div>
        @if (!empty(Auth::user()->login))
                <span class="mr-3" style="font-size: 22px; color: #2C73BB;">
                            {{ Auth::user()->login }}
                           <i class="fas fa-circle-check" style="color: green; margin-left: 5px;"></i>
                        </span>
            @endif

            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="button" class="button" style="margin-top: 15px; border: none; background: transparent;" onClick="confirmLogout()">
                    <i class="fas fa-sign-out-alt" id="logout-btn" style="font-size: 1.3rem; color: #04396E;"></i>
                </button>
            </form>
        @endauth

        @guest
            <button class="btn btn-login" style="border-radius: 8px;" onclick="window.location.href='{{ route('login') }}'">
                <i class="fas fa-user mr-2"></i> Увійти
            </button>
        @endguest
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        function confirmLogout() {
            if (confirm("Ви дійсно бажаєте вийти з акаунта?")) {
                document.querySelector('form').submit();
            }
        }
    </script>

</header>
