@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/shoppingCart.css') }}">
</head>

@section('content')

    <div class="container" style="max-width: 1600px;">
        @include('layouts.header-user')
        <div style="margin-top: 120px; margin-bottom: 30px; text-align: center;">
            <p class="navigate">
                <a href="{{ route('user.main') }}" class="breadcrumb-link">
                    <i class="fa fa-home"></i> Головна
                </a>
                > Кошик
            </p>
            <h2 class="page-title">КОШИК</h2>
        </div>

        <div id="cart-items" class="cart-container"></div>

        <p class="total" id="total">Загальна сума замовлення: <span id="total-price" style="margin-left: 20px;">0 грн</span></p>

        <div id="container-button" class="container-button">
            <button class="continue" onclick="window.location.href='{{ route('user.main') }}'">
                <i class="fas fa-arrow-circle-left"></i>Продовжити покупки
            </button>
            <button class="place-order" id="place-order">
                <i class="fas fa-check"></i>Оформити замовлення
            </button>
        </div>

    </div>

    @include('layouts.footer-user')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userId = '{{ auth()->user()->id }}';
            const cart = JSON.parse(localStorage.getItem(`cart_${userId}`)) || [];
            const cartItemsContainer = document.getElementById('cart-items');
            const placeOrder = document.getElementById('place-order');
            const totalPriceElement = document.getElementById('total-price');
            const total = document.getElementById('total');

            let totalOrderPrice = 0;

            if (cart.length === 0) {
                cartItemsContainer.innerHTML = '<p class="empty-cart">Ваш кошик порожній.</p>';
                placeOrder.style.display = 'none';
                total.style.display = 'none';
            } else {
                cart.forEach(product => {
                    const totalPrice = (product.actualPrice * product.quantity).toFixed(2);
                    totalOrderPrice += parseFloat(totalPrice);

                    const productElement = `
                <div class="cart-item">
                    <div class="cart-item-info">
                        <img src="${product.images[0]}" alt="${product.name}" class="cart-item-image" />
                        <div class="cart-item-details">
                            <h3 class="product-name">${product.name} (${product.article})</h3>
                            <p class="product-weight">Вага: ${product.size} г</p>
                            <div class="quantity-control">
                                <div class="row-price">
                                    <div class="quantity-decrease" style="padding: 2px 12px; background-color: #2c73bb; color: white; cursor: pointer;">-</div>
                                    <span class="quantity-value">${product.quantity}</span>
                                    <div class="quantity-increase" style="padding: 2px 12px; background-color: #2c73bb; color: white; cursor: pointer;">+</div>
                                </div>
                            </div>
                            ${
                        product.price === product.actualPrice
                            ? `<p class="product-price" style="font-size: 18px; font-weight: bold;">${product.actualPrice} грн</p>`
                            : `
                                        <span class="product-price" style="text-decoration: line-through;">${product.price} грн</span>
                                        <span class="product-actual-price" style="font-size: 18px; margin-left: 10px;">${product.actualPrice} грн</span>
                                      `
                    }
                            <p class="total-price">Разом: ${totalPrice} грн</p>
                        </div>
                        <button class="remove-item">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
                    cartItemsContainer.innerHTML += productElement;
                });

                totalPriceElement.innerText = `${totalOrderPrice.toFixed(2)} грн`;
            }

            document.querySelectorAll('.quantity-decrease').forEach((button, index) => {
                button.addEventListener('click', () => updateQuantity(index, -1));
            });

            document.querySelectorAll('.quantity-increase').forEach((button, index) => {
                button.addEventListener('click', () => updateQuantity(index, 1));
            });

            function updateQuantity(index, change) {
                const newQuantity = cart[index].quantity + change;

                if (newQuantity > 0 && newQuantity <= cart[index].quantityDB) {
                    cart[index].quantity = newQuantity;
                    localStorage.setItem(`cart_${userId}`, JSON.stringify(cart));
                    location.reload();
                } else {
                    alert('Ви не можете додати більше товарів, ніж є в наявності.');
                }
            }

            document.querySelectorAll('.remove-item').forEach((button, index) => {
                const productName = cart[index].name;
                button.addEventListener('click', () => removeItem(index, productName));
            });

            function removeItem(index, productName) {
                const confirmDelete = confirm(`Ви дійсно хочете видалити товар ${productName} з кошика?`);

                if (confirmDelete) {
                    cart.splice(index, 1);
                    localStorage.setItem(`cart_${userId}`, JSON.stringify(cart));
                    location.reload();
                }
            }
        });
    </script>


@endsection
