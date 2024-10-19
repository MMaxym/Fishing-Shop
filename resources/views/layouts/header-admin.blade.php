<head>
    <link rel="stylesheet" href="{{ asset('css/header-admin.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<header class="header-style">
    <div class="d-flex align-items-center ml-4">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mr-3" style="width: 50px; height: auto;">
            <h1 class="mb-0" style="font-size: 28px; font-weight: 500; color: #04396E;">Сторінка адміністратора</h1>
    </div>

    <nav class="d-flex align-items-center">
        <ul class="nav mx-auto">
            <li class="nav-item">
                <a href="{{ route('admin.admin') }}" class="nav-link highlighted mx-2 px-4 py-2 {{ request()->routeIs('admin.admin') ? 'active' : '' }}">Головна</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link highlighted mx-2 px-4 py-2 {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">Користувачі</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.products.index') }}" class="nav-link highlighted mx-2 px-4 py-2 {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">Товари</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link highlighted mx-2 px-4 py-2 {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">Замовлення</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.discounts.index') }}" class="nav-link highlighted mx-2 px-4 py-2 {{ request()->routeIs('admin.discounts.index') ? 'active' : '' }}">Знижки</a>
            </li>
        </ul>
    </nav>

    <div class="d-flex align-items-center mr-4">
        <i class="bi bi-person-circle mr-3" style="font-size: 2rem; color: #04396E;"></i>
                    @if (!empty(Auth::user()->login))
                        <span class="mr-3" style="font-size: 22px; color: #2C73BB;">
                            {{ Auth::user()->login }}
                           <i class="fas fa-circle-check" style="color: green; margin-left: 5px;"></i>
                        </span>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="button" class="button" style="border: none; background: transparent;" onClick="confirmLogout()">
                            <i class="fas fa-sign-out-alt" id="logout-btn" style="font-size: 1.3rem; color: #04396E;"></i>
                        </button>
                    </form>
    </div>

</header>

<script>
    function confirmLogout() {
        if (confirm("Ви дійсно бажаєте вийти з акаунта?")) {
            document.querySelector('form').submit();
        }
    }
</script>

