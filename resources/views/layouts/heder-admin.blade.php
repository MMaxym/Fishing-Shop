<header class="w-100 d-flex justify-content-between align-items-center py-3" style="background: linear-gradient(90deg, #4b6cb7, #182848); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); position: fixed; top: 0; left: 0; width: 100vw; z-index: 1000;">
    <div class="d-flex align-items-center ml-4">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mr-3" style="width: 50px; height: auto;">
        <h1 class="mb-0 text-white" style="font-size: 24px; font-weight: 600;">Сторінка адміністратора</h1>
    </div>

    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link btn btn-outline-light mx-4 px-4 py-2">Користувачі</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.products.index') }}" class="nav-link btn btn-outline-light mx-4 px-4 py-2">Товари</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.discounts.index') }}" class="nav-link btn btn-outline-light mx-4 px-4 py-2">Знижки</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link btn btn-outline-light mx-4 px-4 py-2">Замовлення</a>
            </li>
        </ul>

    </nav>
</header>
