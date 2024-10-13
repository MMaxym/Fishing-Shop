<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<header class="header-style">
    <div class="d-flex align-items-center ml-4">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mr-3" style="width: 50px; height: auto;">
        <h1 class="mb-0" style="font-size: 28px; font-weight: 500; color: #04396E;">Fishing Shop</h1>
    </div>

    <div class="search-container d-flex align-items-center">
        <div class="position-relative w-100">
            <input type="text" class="form-control search-input" placeholder="Пошук">
            <i class="fa fa-search search-icon"></i>
        </div>
    </div>

    <nav class="d-flex align-items-center">
        <ul class="nav mx-auto">
            <li class="nav-item">
                <a href="{{ route('user.main') }}" class="nav-link highlighted mx-2 px-4 py-2 {{ request()->routeIs('user.main') ? 'active' : '' }}">Головна</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link highlighted mx-2 px-4 py-2 {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">Про нас</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link highlighted mx-2 px-4 py-2 {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">Акції</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link highlighted mx-2 px-4 py-2 {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">Доставка</a>
            </li>
        </ul>
    </nav>

    <div class="d-flex align-items-center mr-4">
        @auth
            <button class="btn p-0 mr-3" style="border: none; background: transparent;">
                <i class="fas fa-history" style="font-size: 1.5rem; color: #04396E;"></i>
            </button>

            <button class="btn p-0 mr-3" style="border: none; background: transparent;">
                <i class="fas fa-shopping-bag" style="font-size: 1.5rem; color: #04396E; margin-left: 5px;"></i>
            </button>

            <div class="vr" style="height: 40px; width: 2px; background-color: #04396E; margin-left: 15px; margin-right: 25px;"></div>

            <button class="btn p-0 mr-3" style="border: none; background: transparent;">
                <i class="bi bi-person-circle" style="font-size: 2rem; color: #04396E;"></i>
            </button>

            @if (!empty(Auth::user()->login))
                <span class="mr-3" style="font-size: 22px; color: #2C73BB;">
                            {{ Auth::user()->login }}
                           <i class="fas fa-circle-check" style="color: green; margin-left: 5px;"></i>
                        </span>
            @endif

            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-outline-light px-3 py-2" style="border: none; background: transparent;">
                    <i class="fas fa-sign-out-alt" style="font-size: 1.3rem; color: #04396E;"></i>
                </button>
            </form>
        @endauth

        @guest
            <button class="btn btn-login" style="border-radius: 8px;" onclick="window.location.href='{{ route('login') }}'">
                <i class="fas fa-user mr-2"></i> Увійти
            </button>
        @endguest
    </div>

    <style>

        .header-style {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            background: #D0DAF3;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .nav-link {
            position: relative;
            text-decoration: none;
            color: #2C73BB;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: 0;
            left: 50%;
            background-color: #04396E;
            transition: width 0.4s ease, left 0.4s ease;
        }

        .nav-link:hover::after {
            width: 100%;
            left: 0;
        }

        .nav-link:hover {
            color: #04396E;
        }

        .highlighted {
            font-size: 20px;
            color: #2C73BB;
        }

        .highlighted:hover {
            color: #04396E;
        }

        .active {
            color: #04396E;
            font-weight: bold;
        }

        .active::after {
            width: 100%;
            left: 0;
            background-color: #04396E;
        }

        .search-container {
            margin-left: 0;
            margin-right: 0;
        }

        .search-input {
            width: 100%;
            padding-right: 40px;
            border-radius: 8px;
            border: 1px solid #ccc;
            height: 40px;
        }

        .search-input::placeholder {
            color: #2C73BB;
            opacity: 1;
        }

        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #2C73BB;
            pointer-events: none;
            font-size: 16px;
        }

        .btn-login{
            background-color: #2C73BB;
            width: 130px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            color: white;
        }

        .btn-login:hover{
            background-color: #266198;
            color: white;
        }

    </style>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</header>
