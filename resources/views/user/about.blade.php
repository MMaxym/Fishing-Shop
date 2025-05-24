@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/about.css') }}">
</head>

@section('content')

    @include('layouts.header-user')

    <main class="main-section">
        <section class="main-row">
            <div class="main-content-text">
                <h2 class="main-title">Перевірені приманки<br>для справжнього улову</h2>
                <p class="main-description">
                    Тейлспінери, пількери, балансири – тільки робочі рішення.<br>
                    У світі риболовлі немає місця випадковостям — важлива кожна деталь.
                    Саме тому ми обираємо лише ті приманки, які відмінно працюють, перевірені
                    в реальних умовах, на різних водоймах і за різної активності риби.
                </p>
                <button class="empty-cart-btn" onclick="window.location.href='{{ route('user.main') }}'">Перейти до покупок
                    <img  class="empty-cart-btn-icon" src="{{ asset('images/v2/icon/ArrowBigRightHomeLink.svg') }}" alt="moreIcon">
                </button>
            </div>
            <div class="main-image-wrapper">
                <img src="{{ asset('images/v2/img/about-img-1.svg') }}" alt="Перевірені приманки" class="main-image" />
            </div>
        </section>

        <section class="main-row">
            <div class="main-benefits-wrapper">
                <h2 class="benefits-title">100% НАДІЙНІСТЬ</h2>
                <p class="benefits-subtitle">
                    Ми дбаємо про те, щоб кожна ваша риболовля була успішною. У нашому магазині ви знайдете тільки перевірені тейлспінери, пількери та балансири, які показали себе на водоймах України та за її межами. Ми самі рибалки — і обираємо найкраще!
                </p>

                <div class="benefits-grid">
                    <div class="benefit-item">
                        <div class="benefit-icon-section">
                            <img src="{{ asset('images/v2/icon/AboutPercent.svg') }}" alt="Перевага 1" class="benefit-icon">
                        </div>
                        <div class="text">
                            <h3>100% Робочі приманки</h3>
                            <p>Тестовані досвідом, перевірені в польових умовах</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon-section">
                            <img src="{{ asset('images/v2/icon/AboutPay.svg') }}" alt="Перевага 2" class="benefit-icon">
                        </div>
                        <div class="text">
                            <h3>Безпечна оплата</h3>
                            <p>Ваші кошти — під захистом</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon-section">
                            <img src="{{ asset('images/v2/icon/AboutPhoneFilled.svg') }}" alt="Перевага 3" class="benefit-icon">
                        </div>
                        <div class="text">
                            <h3>Постійна підтримка</h3>
                            <p>Маєте питання — ми завжди на зв’язку</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon-section">
                            <img src="{{ asset('images/v2/icon/AboutSmile.svg') }}" alt="Перевага 4" class="benefit-icon">
                        </div>
                        <div class="text">
                            <h3>Задоволені клієнти</h3>
                            <p>Рибалки з усієї України нам довіряють</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon-section">
                            <img src="{{ asset('images/v2/icon/AboutFish.svg') }}" alt="Перевага 5" class="benefit-icon">
                        </div>
                        <div class="text">
                            <h3>Приманки для будь-якої риби</h3>
                            <p>Від окуня до щуки — знайдеться на всіх</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon-section">
                            <img src="{{ asset('images/v2/icon/AboutSaleOutline.svg') }}" alt="Перевага 6" class="benefit-icon">
                        </div>
                        <div class="text">
                            <h3>Знижки на замовлення</h3>
                            <p>При замовленні від 1000 гривень, ще й знижки!</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon-section">
                            <img src="{{ asset('images/v2/icon/AboutSupport.svg') }}" alt="Перевага 7" class="benefit-icon">
                        </div>
                        <div class="text">
                            <h3>Миттєвий зв’язок з нами</h3>
                            <p>Телеграм, вайбер, пошта — як вам зручно</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon-section">
                            <img src="{{ asset('images/v2/icon/AboutBatter.svg') }}" alt="Перевага 8" class="benefit-icon">
                        </div>
                        <div class="text">
                            <h3>Гарантований улов</h3>
                            <p>Ви не повернетеся з порожніми руками!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="decoration-row">
            <img src="{{ asset('images/v2/img/decoration-img.svg') }}" alt="Розділювач" class="decoration-img">
        </div>

        <section class="main-row" id="about-row-2">
            <div class="fishing-image">
                <img src="{{ asset('images/v2/img/about-img-2.svg') }}" alt="Про нас" class="about-img">
            </div>
            <div class="fishing-text">
                <h2>Трохи душі</h2>
                <p>
                    Ми віримо, що риболовля — це не лише про улов.<br>
                    Це — про спокій, пригоди, дружбу і незабутні моменти. І наша місія — <br> зробити ці моменти ще яскравішими, допомагаючи кожному рибалці <br>
                    знайти “свою” приманку.
                </p>
                <p class="last-line">Закинь з нами — і відчуй різницю!</p>
            </div>
        </section>
    </main>

    @include('layouts.footer-user')

    <script src="{{ asset('js/user/about.js') }}"></script>

@endsection
