<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
                <span class="mr-3" style="font-size: 22px; color: #04396E;">{{ Auth::user()->login }}</span>

                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                        <button type="submit" class="btn btn-outline-light px-3 py-2" style="border: none; background: transparent;">
                            <i class="fas fa-sign-out-alt" style="font-size: 1.3rem; color: #04396E;"></i>
                        </button>
                </form>
    </div>

</header>

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
        width: 100vw;
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
</style>
