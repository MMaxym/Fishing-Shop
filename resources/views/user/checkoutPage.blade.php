@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/checkoutPage.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
</head>


@section('content')

    <div class="container" style="max-width: 1600px;">
        @include('layouts.header-user')
        <div style="margin-top: 130px; margin-bottom: 30px; text-align: center;">
            <p class="navigate">
                <a href="{{ route('user.main') }}" class="breadcrumb-link">
                    <i class="fa fa-home"></i> Головна
                </a>
                >
                <a href="{{ route('user.shoppingCart') }}" class="breadcrumb-link" style="margin-left: 5px;"> Кошик</a>
                > Оформлення замовлення
            </p>
            <h2 class="page-title">ОФОРМЛЕННЯ ЗАМОВЛЕННЯ</h2>
            <div class="container2">
                <div class="payment-shipping">
                    <p class="info-about">Інформація про вас</p>
                    <form style="margin-bottom: 0;">
                        <div class="form-group">
                            <label for="fullname">Прізвище та імʼя</label>
                            <input type="text" id="fullname" placeholder="Прізвище та імʼя"
                                   value="@auth {{ Auth::user()->surname }} {{ Auth::user()->name }} @else Данні не введено @endauth" required>
                            <p class="error-message" style="text-align: left; width: 130px !important; font-size: 14px; color: #c53727; margin: 0; display: none;">
                                *Обовʼязкове поле
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="email">Електронна пошта</label>
                            <input type="email" id="email" placeholder="Електронна пошта"
                                   value="@auth {{ Auth::user()->email }} @else Данні не введено @endauth" required>
                            <p class="error-message" style="text-align: left; width: 130px !important; font-size: 14px; color: #c53727; margin: 0; display: none;">
                                *Обовʼязкове поле
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="phone">Номер телефону</label>
                            <input type="text" id="phone" placeholder="Номер телефону"
                                   value="@auth {{ Auth::user()->phone }} @else Данні не введено @endauth" required>
                            <p class="error-message" style="text-align: left; width: 130px !important; font-size: 14px; color: #c53727; margin: 0; display: none;">
                                *Обовʼязкове поле
                            </p>
                        </div>
                    </form>
                </div>

                <div class="payment-shipping">
                    <h3>Доставка</h3>
                    <div class="shipping-method">
                        <button class="active" data-method="nova-poshta">Нова Пошта</button>
                        <button data-method="ukrposhta">Укрпошта</button>
                        <button data-method="pickup">Самовивіз</button>
                        <button data-method="courier">Кур'єром</button>
                    </div>

                    <div class="shipping-fields">
                        <div class="nova-poshta-fields">
                            <div class="checkout-container">
                                <div class="form-group">
                                    <label for="city">Оберіть місто:</label>
                                    <select id="cityNP" name="city" style="width: 500px; padding: 12px; border: 2px solid #cdcdcd; border-radius: 8px; font-size: 16px; color: #7c7c7c;" required>
                                        <option value="">Оберіть місто</option>
                                    </select>
                                    <p class="error-message-delivery" style="text-align: left; width: 130px !important; font-size: 14px; color: #c53727; margin: 0; display: none;">*Обовʼязкове поле</p>
                                </div>

                                <div class="form-group">
                                    <label for="warehouse">Оберіть відділення:</label>
                                    <select id="warehouse" name="warehouse" style="width: 500px; padding: 12px; border: 2px solid #cdcdcd; border-radius: 8px; font-size: 16px; color: #7c7c7c;" required>
                                        <option value="">Оберіть відділення</option>
                                    </select>
                                    <p class="error-message-delivery2" style="text-align: left; width: 130px !important; font-size: 14px; color: #c53727; margin: 0; display: none;">*Обовʼязкове поле</p>
                                </div>

                                <div style="text-align: left;">
                                    <label for="deliveryCost">Вартість доставки:</label>
                                    <span id="deliveryCost">0</span> грн
                                </div>
                            </div>
                        </div>

                        <div class="ukrposhta-fields" style="display: none;">
                            <div class="form-group">
                                <label for="ukrposhta-address">Адреса</label>
                                <p style="text-align: left; width: 600px !important; font-size: 14px; color: #000000">*Введіть дані у форматі "місто, код відділення (наприклад 29001)"</p>
                                <input type="text" id="ukrposhta-address" placeholder="Введіть адресу" style="width: 300px;" required>
                                <p class="error-message-delivery3" style="text-align: left; width: 130px !important; font-size: 14px; color: #c53727; margin: 0; display: none;">*Обовʼязкове поле</p>
                            </div>
                        </div>

                        <div class="courier-fields" style="display: none;">
                            <div class="form-group">
                                <label for="courier-address">Адреса</label>
                                <p style="text-align: left; width: 400px !important; font-size: 14px; color: #000000">*Курʼєрська доставка тільки по м.Хмельницький</p>
                                <input type="text" id="courier-address" placeholder="Введіть адресу" style="width: 300px;" required>
                                <p class="error-message-delivery4" style="text-align: left; width: 130px !important; font-size: 14px; color: #c53727; margin: 0; display: none;">*Обовʼязкове поле</p>
                            </div>
                        </div>

                        <div class="pickup-fields" style="display: none; text-align: left; font-size: 16px; color: #2c73bb;">
                            <p style="width: 420px;">Самовивіз доступний з нашого магазину за адресою: вул. Зарічанська 10, м.Хмельницький</p>
                        </div>
                    </div>
                </div>

                <div class="payment-shipping">
                    <h3>Оплата</h3>
                    <div class="payment-method">
                        <button class="active">Visa/Mastercard</button>
                        <button>Післяплата</button>
                    </div>
                </div>

                <div class="order-summary">
                    <h3>Підтвердження замовлення</h3>
                    <table>
                        <thead>
                        <tr>
                            <th>Назва</th>
                            <th>К-сть</th>
                            <th>Ціна</th>
                            <th>Загальна ціна</th>
                        </tr>
                        </thead>
                        <tbody id="order-items">
                        </tbody>
                    </table>
                </div>

                <div class="total-summary">
                    <div class="row">
                        <span>Вартість товарів:</span>
                        <span id="total-price">0 грн</span>
                    </div>
                    <div class="row delivery">
                        <span>Вартість доставки:</span>
                        <span id="delivery_cost">0 грн</span>
                    </div>
                    <div class="row discount">
                        <span>Знижка:</span>
                        <span>Немає</span>
                    </div>
                    <div class="row total">
                        <span>Разом до сплати:</span>
                        <span id="sum">0 грн</span>
                    </div>
                </div>

                <div class="row" style="padding: 0 20px;">
                    <button class="cancel-order-btn" onclick="window.location.href='{{ route('user.main') }}'">
                        <i class="fas fa-cancel" style="margin-right: 5px;" ></i> Скасувати
                    </button>
                    <button class="confirm-order-btn">
                        <i class="fas fa-check-circle" style="margin-right: 5px;"></i> Підтвердити замовлення
                    </button>
                </div>
            </div>
        </div>
        <div id="scrollToTop" class="scroll-to-top">
            <i class="fas fa-arrow-up"></i>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script>
        const buttons2 = document.querySelectorAll('.payment-method button');

        buttons2.forEach(button => {
            button.addEventListener('click', function() {
                buttons2.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
            });
        });

        const buttons = document.querySelectorAll('.shipping-method button');

        const novaPoshtaFields = document.querySelector('.nova-poshta-fields');
        const ukrposhtaFields = document.querySelector('.ukrposhta-fields');
        const courierFields = document.querySelector('.courier-fields');
        const pickupFields = document.querySelector('.pickup-fields');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                buttons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const method = this.getAttribute('data-method');

                novaPoshtaFields.style.display = 'none';
                ukrposhtaFields.style.display = 'none';
                courierFields.style.display = 'none';
                pickupFields.style.display = 'none';

                if (method === 'nova-poshta') {
                    novaPoshtaFields.style.display = 'block';
                } else if (method === 'ukrposhta') {
                    ukrposhtaFields.style.display = 'block';
                } else if (method === 'courier') {
                    courierFields.style.display = 'block';
                } else if (method === 'pickup') {
                    pickupFields.style.display = 'block';
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            fetch('/api/novaposhta/cities')
                .then(response => response.json())
                .then(data => {
                    const citySelect = document.getElementById('cityNP');
                    data.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.Ref;
                        option.textContent = city.Description;
                        citySelect.appendChild(option);
                    });

                    const choices = new Choices('#cityNP', {
                        searchEnabled: true,
                        placeholderValue: 'Оберіть місто',
                        noResultsText: 'Нічого не знайдено',
                        searchPlaceholderValue: 'Шукати ...',
                    });

                })
                .catch(error => console.error('Помилка пошуку:', error));

            document.getElementById('cityNP').addEventListener('change', function () {
                const cityRef = this.value;
                if (cityRef) {
                    fetch(`/api/novaposhta/warehouses/${cityRef}`)
                        .then(response => response.json())
                        .then(data => {
                            const warehouseSelect = document.getElementById('warehouse');
                            warehouseSelect.innerHTML = '<option value="">Оберіть відділення</option>';
                            data.forEach(warehouse => {
                                const option = document.createElement('option');
                                option.value = warehouse.Ref;
                                option.textContent = warehouse.Description;
                                warehouseSelect.appendChild(option);
                            });

                            const choices = new Choices('#warehouse', {
                                searchEnabled: true,
                                placeholderValue: 'Оберіть відділення',
                                noResultsText: 'Нічого не знайдено',
                                searchPlaceholderValue: 'Шукати ...',
                            });
                        });

                    fetch(`/api/novaposhta/delivery-cost/${cityRef}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('deliveryCost').textContent = data.cost + '.00';
                        });
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const userId = @auth {{ Auth::user()->id }} @else 'Немає' @endauth;
            const cart = JSON.parse(localStorage.getItem(`cart_${userId}`)) || [];
            const orderItemsContainer = document.getElementById('order-items');
            const totalPriceElement = document.getElementById('total-price');

            let totalOrderPrice = 0;

            cart.forEach(product => {
                const totalPrice = (product.actualPrice * product.quantity).toFixed(2);
                totalOrderPrice += parseFloat(totalPrice);

                const row = `
                <tr>
                    <td>${product.name}</td>
                    <td>${product.quantity}</td>
                    <td>${product.actualPrice}.00 грн</td>
                    <td>${totalPrice} грн</td>
                </tr>
            `;
                orderItemsContainer.innerHTML += row;
            });

            totalPriceElement.innerText = `${totalOrderPrice.toFixed(2)} грн`;
        });

        document.addEventListener('DOMContentLoaded', function() {
            const deliveryCostElement = document.getElementById('delivery_cost');
            const citySelect = document.getElementById('cityNP');
            const shippingButtons = document.querySelectorAll('.shipping-method button');

            function updateNovaPoshtaCost(cityRef) {
                if (cityRef) {
                    fetch(`/api/novaposhta/delivery-cost/${cityRef}`)
                        .then(response => response.json())
                        .then(data => {
                            const cost = data.cost || 0;
                            deliveryCostElement.textContent = `${cost}.00 грн`;
                        })
                        .catch(error => console.error('Помилка отримання ціни доставки:', error));
                }
            }

            citySelect.addEventListener('change', function() {
                const cityRef = citySelect.value;
                updateNovaPoshtaCost(cityRef);
            });

            shippingButtons.forEach(button => {
                button.addEventListener('click', function() {
                    shippingButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');

                    const method = button.getAttribute('data-method');
                    if (method === 'nova-poshta') {
                        const cityRef = citySelect.value;
                        updateNovaPoshtaCost(cityRef);
                        toggleFields('nova-poshta');
                    }
                    else if (method === 'ukrposhta') {
                        deliveryCostElement.textContent = '50.00 грн';
                        toggleFields('ukrposhta');
                    }
                    else if (method === 'pickup') {
                        deliveryCostElement.textContent = '0 грн';
                        toggleFields('pickup');
                    }
                    else if (method === 'courier') {
                        deliveryCostElement.textContent = '150.00 грн';
                        toggleFields('courier');
                    }
                });
            });

            function toggleFields(method) {
                document.querySelector('.nova-poshta-fields').style.display = method === 'nova-poshta' ? 'block' : 'none';
                document.querySelector('.ukrposhta-fields').style.display = method === 'ukrposhta' ? 'block' : 'none';
                document.querySelector('.courier-fields').style.display = method === 'courier' ? 'block' : 'none';
                document.querySelector('.pickup-fields').style.display = method === 'pickup' ? 'block' : 'none';
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const totalPriceElement = document.getElementById('total-price');
            const discountElement = document.querySelector('.discount span:last-child');

            function calculateDiscount() {
                const totalPrice = parseFloat(totalPriceElement.textContent) || 0;
                let discount = 0;

                if (totalPrice >= 3000) {
                    discount = 10;
                }
                else if (totalPrice >= 2000) {
                    discount = 5;
                }
                else if (totalPrice >= 1000) {
                    discount = 3;
                }

                if (discount > 0) {
                    const discountAmount = (totalPrice * discount) / 100;
                    discountElement.textContent = `${discount}% (-${discountAmount.toFixed(2)} грн)`;
                }
                else {
                    discountElement.textContent = 'Немає';
                }
            }

            calculateDiscount();

            const observer = new MutationObserver(calculateDiscount);
            observer.observe(totalPriceElement, { childList: true });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const totalPriceElement = document.getElementById('total-price');
            const deliveryCostElement = document.getElementById('delivery_cost');
            const discountElement = document.querySelector('.discount span:last-child');
            const totalAmountElement = document.querySelector('.total span:last-child');

            function calculateTotalAmount() {
                const totalPrice = parseFloat(totalPriceElement.textContent) || 0;
                const deliveryCost = parseFloat(deliveryCostElement.textContent) || 0;

                let discountAmount = 0;
                if (discountElement.textContent.includes('%')) {
                    const discountPercent = parseFloat(discountElement.textContent) || 0;
                    discountAmount = (totalPrice * discountPercent) / 100;
                }

                const finalAmount = totalPrice + deliveryCost - discountAmount;

                if (discountAmount > 0) {
                    totalAmountElement.textContent = `${finalAmount.toFixed(2)} грн`;
                }
                else {
                    totalAmountElement.textContent = `${(totalPrice + deliveryCost).toFixed(2)} грн`;
                }

                fetch('{{ route("user.deliveryCost") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ deliveryCost })
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Delivery cost updated in session:', data);
                    })
                    .catch(error => {
                        console.error('Error updating delivery cost:', error);
                    });
            }

            calculateTotalAmount();

            const observer = new MutationObserver(calculateTotalAmount);
            observer.observe(totalPriceElement, { childList: true });
            observer.observe(deliveryCostElement, { childList: true });
            observer.observe(discountElement, { childList: true });
        });

        document.querySelectorAll('.shipping-method button').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.shipping-method button').forEach(btn => btn.classList.remove('active'));

                this.classList.add('active');

                const method = this.getAttribute('data-method');

                document.querySelectorAll('.shipping-fields > div').forEach(field => {
                    field.style.display = 'none';
                    const inputs = field.querySelectorAll('input, select');
                    inputs.forEach(input => input.removeAttribute('required'));
                });

                if (method === 'nova-poshta') {
                    document.querySelector('.nova-poshta-fields').style.display = 'block';
                    document.getElementById('cityNP').setAttribute('required', true);
                    document.getElementById('warehouse').setAttribute('required', true);
                }
                else if (method === 'ukrposhta') {
                    document.querySelector('.ukrposhta-fields').style.display = 'block';
                    document.getElementById('ukrposhta-address').setAttribute('required', true);
                }
                else if (method === 'courier') {
                    document.querySelector('.courier-fields').style.display = 'block';
                    document.getElementById('courier-address').setAttribute('required', true);
                }
                else if (method === 'pickup') {
                    document.querySelector('.pickup-fields').style.display = 'block';
                }
            });
        });


        document.querySelector('.confirm-order-btn').addEventListener('click', () => {

            const errorMessages = document.querySelectorAll('.error-message');
            errorMessages.forEach(message => {
                message.style.display = 'none';
            });

            const fullname = document.getElementById('fullname').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;

            let hasError = false;

            if (!fullname.trim()) {
                document.querySelector('#fullname + .error-message').style.display = 'block';
                hasError = true;
            }
            if (!email.trim()) {
                document.querySelector('#email + .error-message').style.display = 'block';
                hasError = true;
            }
            if (!phone.trim()) {
                document.querySelector('#phone + .error-message').style.display = 'block';
                hasError = true;
            }

            if (hasError) {
                window.scrollTo(0, 0);
                return;
            }

            const selectedShippingMethod = document.querySelector('.shipping-method button.active');
            const selectedPaymentMethod = document.querySelector('.payment-method button.active');

            if (!selectedShippingMethod) {
                alert('Будь ласка, оберіть метод доставки.');
                return;
            }

            if (!selectedPaymentMethod) {
                alert('Будь ласка, оберіть метод оплати.');
                return;
            }

            const userId = @auth {{ Auth::user()->id }} @else 'Немає' @endauth;
            let address = '';
            let shippingCost = 0;

            if (selectedShippingMethod.getAttribute('data-method') === 'nova-poshta') {
                const cityNP = document.getElementById('cityNP');
                const warehouse = document.getElementById('warehouse');
                const deliveryErrorMessage = document.querySelector('.error-message-delivery');
                const deliveryErrorMessage2 = document.querySelector('.error-message-delivery2');


                if (cityNP.selectedIndex === 0) {
                    deliveryErrorMessage.style.display = 'block';
                    window.scrollTo(0, 400);
                    return;
                }
                if (warehouse.selectedIndex === 0) {
                    deliveryErrorMessage.style.display = 'none';
                    deliveryErrorMessage2.style.display = 'block';
                    window.scrollTo(0, 400);
                    return;
                }
                address = cityNP.options[cityNP.selectedIndex].text + ', ' + warehouse.options[warehouse.selectedIndex].text;
                shippingCost = parseFloat(document.getElementById('delivery_cost').value) || 0;
            }
            else if (selectedShippingMethod.getAttribute('data-method') === 'ukrposhta') {
                address = document.getElementById('ukrposhta-address').value;
                const deliveryErrorMessage3 = document.querySelector('.error-message-delivery3');

                if (!address.trim()) {
                    deliveryErrorMessage3.style.display = 'block';
                    window.scrollTo(0, 400);
                    return;
                }
                shippingCost = 50.00;
            }
            else if (selectedShippingMethod.getAttribute('data-method') === 'courier') {
                address = 'м.Хмельницький, ' + document.getElementById('courier-address').value;
                const deliveryErrorMessage4 = document.querySelector('.error-message-delivery4');

                if (!document.getElementById('courier-address').value.trim()) {
                    deliveryErrorMessage4.style.display = 'block';
                    window.scrollTo(0, 400);
                    return;
                }
                shippingCost = 150.00;
            }
            else if (selectedShippingMethod.getAttribute('data-method') === 'pickup') {
                address = 'Самовивіз';
                shippingCost = 0.00;
            }

            const products = JSON.parse(localStorage.getItem(`cart_${userId}`)) || [];
            const totalAmount = parseFloat(document.getElementById('sum').innerText.replace(' грн', '')) || 0;

            const discountElement = document.querySelector('.discount span:last-child');
            const totalPriceElement = document.getElementById('total-price');
            const totalPrice = parseFloat(totalPriceElement.textContent) || 0;

            let discountAmount = 0;
            let discountId = null;

            if (discountElement.textContent.includes('%')) {
                const discountPercent = parseFloat(discountElement.textContent) || 0;
                discountAmount = (totalPrice * discountPercent) / 100;

                if (discountPercent === 3) {
                    discountId = 14;
                }
                else if (discountPercent === 5) {
                    discountId = 15;
                }
                else if (discountPercent === 10) {
                    discountId = 16;
                }
            }

            const finalAmount = (totalAmount - discountAmount).toFixed(2);

            if (finalAmount <= 0) {
                alert('Загальна сума повинна бути більша за 0 грн.');
                return;
            }

            fetch('{{ route("user.confirmOrder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    shipping_method: selectedShippingMethod.getAttribute('data-method'),
                    payment_method: selectedPaymentMethod.innerText === 'Visa/Mastercard' ? 'visa' : 'postpaid',
                    address,
                    shipping_cost: shippingCost,
                    total_amount: totalAmount,
                    discount_id: discountId,
                    products,
                    fullname,
                    email,
                    phone
                })
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    localStorage.removeItem(`cart_${userId}`);
                    window.location.href = '{{ route("user.main") }}';
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

        window.onscroll = function () {
            const scrollToTopButton = document.getElementById("scrollToTop");
            if (window.scrollY > 200) {
                scrollToTopButton.style.display = "block";
            } else {
                scrollToTopButton.style.display = "none";
            }
        };

        document.getElementById("scrollToTop").onclick = function () {
            window.scrollTo({ top: 0, behavior: "smooth" });
        };

    </script>

    @include('layouts.footer-user')
@endsection
