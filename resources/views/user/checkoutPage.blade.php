@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/checkoutPage.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
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
                            <a href="{{ route('user.orderHistory') }}">
                                Кошик
                            </a>
                            <span class="breadcrumb-separator">
                                <img src="{{ asset('images/v2/icon/ArrowSmallRightNav.svg') }}" alt="Arrow Icon">
                            </span>
                        </li>
                        <li class="current-product"> Оформлення замовлення</li>
                    </ul>
                </nav>
            </div>
        </section>
        <section class="main-row">
            <div class="products-wrapper">
                <h2 class="row-title">Оформлення замовлення</h2>
                <div class="checkout-products">
                    <div class="checkout-items-container">
                        <div class="payment-shipping">
                            <p class="info-about">Інформація про вас</p>
                            <form class="personal-info">
                                <div class="form-group">
                                    <label for="fullname">Прізвище та імʼя</label>
                                    <input type="text" id="fullname" placeholder="Прізвище та імʼя"
                                           value="@auth{{ Auth::user()->surname }} {{ Auth::user()->name }} @else Данні не введено @endauth" required>
                                    <p class="error-message">
                                        *Обовʼязкове поле
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label for="email">Електронна пошта</label>
                                    <input type="email" id="email" placeholder="Електронна пошта"
                                           value="@auth{{ Auth::user()->email }} @else Данні не введено @endauth" required>
                                    <p class="error-message">
                                        *Обовʼязкове поле
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Номер телефону</label>
                                    <input type="text" id="phone" placeholder="Номер телефону"
                                           value="@auth{{ Auth::user()->phone }} @else Данні не введено @endauth" required>
                                    <p class="error-message">
                                        *Обовʼязкове поле
                                    </p>
                                </div>
                            </form>
                        </div>

                        <div class="payment-shipping">
                            <p class="info-about">Оберіть спосіб доставки</p>

                            <div class="shipping-methods">
                                <div class="shipping-method">
                                    <div class="shipping-btn">
                                        <button class="active" data-method="nova-poshta"></button>
                                        <p class="shipping-name"> Нова Пошта</p>
                                    </div>
                                    <div class="shipping-btn">
                                        <button data-method="ukrposhta"></button>
                                        <p class="shipping-name"> Укрпошта</p>
                                    </div>
                                    <div class="shipping-btn">
                                        <button data-method="pickup"></button>
                                        <p class="shipping-name"> Самовивіз</p>
                                    </div>
                                    <div class="shipping-btn">
                                        <button data-method="courier"></button>
                                        <p class="shipping-name"> Кур'єром</p>
                                    </div>
                                </div>

                                <div class="shipping-fields">
                                    <div class="nova-poshta-fields">
                                        <div class="checkout-container">
                                            <div class="form-group">
                                                <label for="city">Оберіть місто:</label>
                                                <select id="cityNP" name="city" style="width: 500px;
                                                    border-radius: var(--br-1) !important;
                                                    color: var(--dark-1) !important;
                                                    border: 1px solid var(--light-2) !important;
                                                    font-size: var(--Font-14-size) !important;
                                                    font-weight: var(--Regular-weight)!important;
                                                    text-align: left;
                                                    padding: 10px 16px !important;
                                                    margin: 0 !important; " required>
                                                    <option value="">Оберіть місто</option>
                                                </select>
                                                <p class="error-message-delivery">* Обовʼязкове поле</p>
                                            </div>

                                            <div class="form-group" style="margin-top: 20px !important;">
                                                <label for="warehouse">Оберіть відділення:</label>
                                                <select id="warehouse" name="warehouse" style="width: 500px;
                                                    border-radius: var(--br-1) !important;
                                                    color: var(--dark-1) !important;
                                                    border: 1px solid var(--light-2) !important;
                                                    font-size: var(--Font-14-size) !important;
                                                    font-weight: var(--Regular-weight)!important;
                                                    text-align: left;
                                                    padding: 10px 16px !important;
                                                    margin: 0 !important;" required>
                                                    <option value="">Оберіть відділення</option>
                                                </select>
                                                <p class="error-message-delivery2">* Обовʼязкове поле</p>
                                            </div>

                                            <div class="delivery-cost-name" style="margin-top: 20px !important;">
                                                <label class="delivery-cost-name" for="deliveryCost">Вартість доставки:</label>
                                                <span id="deliveryCost"> 0</span> грн
                                            </div>
                                            <p class="delivery-warning">* Доставка Новою Поштою відбувається протягом 1-2 робочих днів</p>
                                        </div>
                                    </div>

                                    <div class="ukrposhta-fields" style="display: none;">
                                        <div class="form-group">
                                            <label for="ukrposhta-address">Адреса</label>
                                            <p style="text-align: left; min-width: 500px; font-size: var(--Font-14-size); font-weight:var(--Medium-weight); color: var(--main-dark)">* Введіть дані у форматі "місто, код відділення (наприклад 29001)"</p>
                                            <input type="text" id="ukrposhta-address" placeholder="Введіть адресу" required>
                                            <p class="error-message-delivery3">* Обовʼязкове поле</p>
                                        </div>
                                        <p class="delivery-warning-2">* Доставка Укрпоштою відбувається протягом 3-5 робочих днів</p>
                                    </div>

                                    <div class="courier-fields" style="display: none;">
                                        <div class="form-group">
                                            <label for="courier-address">Адреса</label>
                                            <input type="text" id="courier-address" placeholder="Введіть адресу" required>
                                            <p class="error-message-delivery4">* Обовʼязкове поле</p>
                                        </div>
                                        <p class="delivery-warning-2">* Доставка кур’єром доступна лише у м. Хмельницький</p>
                                    </div>

                                    <div class="pickup-fields" style="display: none;">
                                        <p class="pickup-fields-title">Самовивіз доступний з нашого магазину за адресою м.Хмельницький, вул.Зарічанська, б.10</p>
                                        <div id="map" style="width: 520px; height: 300px; margin-top: 15px; border-radius: 24px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-section">
                        <div class="col-main">
                            <p class="col-title">Перелік товарів в замовленні</p>
                            <div class="col-text">
                                <div class="order-summary">
                                    <table>
                                        <tbody id="order-items">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-text">
                                <div class="payment-shipping">
                                    <p class="col-title" style="padding-top: 24px;">Спосіб оплати</p>
                                    <div class="payment-method">
                                        <div class="payment-btn">
                                            <button class="active">
                                                <span style="display: none;">Visa/Mastercard</span>
                                            </button>
                                            <p class="payment-name"> Visa/Mastercard</p>
                                        </div>
                                        <div class="payment-btn">
                                            <button>
                                                <span style="display: none;">Післяплата</span>
                                            </button>
                                            <p class="payment-name"> Післяплата</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="total-summary">
                                <div class="row">
                                    <span>Сума:</span>
                                    <span id="total-price">0 грн</span>
                                </div>
                                <div class="row delivery">
                                    <span>Доставка:</span>
                                    <span id="delivery_cost">безкоштовно</span>
                                </div>
                                <div class="row discount">
                                    <span>Знижка:</span>
                                    <span id="discount">немає</span>
                                </div>
                                <div class="row total">
                                    <span>ВСЬОГО:</span>
                                    <span id="sum">0 грн</span>
                                </div>
                            </div>

                        </div>
                        <div class="col-buttons">
                            <button class="confirm-order-btn">Оформити замовлення
                                <img  class="icon-cart" src="{{ asset('images/v2/icon/PayCart.svg') }}" alt="PayIcon">
                            </button>
                            <button class="cancel-order-btn" onclick="window.location.href='{{ route('user.main') }}'">
                                Скасувати
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap"
        async defer>
    </script>

    <script>
        window.cartData = @json($cart);
        window.userId = @auth {{ Auth::user()->id }} @else 'немає' @endauth;
    </script>

    <script src="{{ asset('js/user/checkoutPage.js') }}"></script>

    @include('layouts.footer-user')

@endsection
