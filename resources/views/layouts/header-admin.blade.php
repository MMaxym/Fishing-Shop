<head>
    <link rel="stylesheet" href="{{ asset('css/header-admin.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<header class="header-admin">
    <div class="logo-section">
        <a href="{{ route('admin.admin') }}" class="logo-link">
            <img class="logo-icon" alt="Logo" title="Перейти на головну" src="{{ asset('images/v2/img/logo-admin.svg') }}">
        </a>
    </div>


    <div class="info-pages">
        <ul class="pages-links">
            <li class="nav-item">
                <a href="{{ route('admin.admin') }}" class="nav-link {{ request()->routeIs('admin.admin') ? 'active' : '' }}">Головна</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">Користувачі</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">Товари</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">Замовлення</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.discounts.index') }}" class="nav-link {{ request()->routeIs('admin.discounts.index') ? 'active' : '' }}">Знижки</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.questions.index') }}" class="nav-link {{ request()->routeIs('admin.questions.index') ? 'active' : '' }}">Запитання</a>
            </li>
        </ul>
    </div>

    <div class="user-pages">
        <i class="bi bi-person-circle mr-2" style="font-size: 1.6rem; color: var(--dark-1);"></i>
        @if (!empty(Auth::user()->login))
            <span class="mr-3" style="font-size: 18px; color: var(--dark-1);">
                            {{ Auth::user()->login }}
                           <i class="fas fa-circle-check" style="color: var(--helps-green); margin-left: 5px;"></i>
                        </span>
        @else
            <span class="mr-3" style="font-size: 18px; color: var(--dark-1);">
                           Адміністратор
                           <i class="fas fa-circle-check" style="color: var(--helps-green); margin-left: 5px;"></i>
                        </span>
        @endif

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="button" class="button" id="logout-btn" style="border: none; background: transparent;">
                <i class="fas fa-sign-out-alt" id="logout-icon" style="font-size: 1.2rem; color: var(--dark-1);"></i>
            </button>
        </form>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const logoutBtn = document.getElementById('logout-btn');

        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Вийти з акаунта?',
                text: "Ви дійсно хочете вийти з акаунта?",
                icon: 'warning',
                background: '#f9feff',
                showCancelButton: true,
                confirmButtonText: 'Так, вийти',
                cancelButtonText: 'Скасувати',
                customClass: {
                    popup: 'custom-swal-popup',
                    title: 'custom-swal-title',
                    htmlContainer: 'custom-swal-text',
                    confirmButton: 'custom-swal-confirm',
                    cancelButton: 'custom-swal-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        });
    });
</script>
