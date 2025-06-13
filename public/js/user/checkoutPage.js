let map;

function initMap() {
    const location = { lat: 49.432973, lng: 27.004561 };

    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 16,
        center: location,
    });

    const marker = new google.maps.Marker({
        position: location,
        map: map,
        title: "м.Хмельницький, вул. Зарічанська, 10",
    });

    const button = document.createElement("button");
    button.textContent = "Прокласти маршрут";
    button.classList.add("custom-map-control-button");
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(button);

    button.addEventListener("click", () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const originLat = position.coords.latitude;
                    const originLng = position.coords.longitude;
                    window.open(
                        `https://www.google.com/maps/dir/?api=1&origin=${originLat},${originLng}&destination=${location.lat},${location.lng}`,
                        "_blank"
                    );
                },
                (error) => {
                    alert("Не вдалося отримати ваше місцезнаходження. Дозвольте доступ до геолокації або спробуйте пізніше.");
                    // fallback: без origin
                    window.open(
                        `https://www.google.com/maps/dir/?api=1&destination=${location.lat},${location.lng}`,
                        "_blank"
                    );
                }
            );
        } else {
            alert("Ваш браузер не підтримує геолокацію.");
            window.open(
                `https://www.google.com/maps/dir/?api=1&destination=${location.lat},${location.lng}`,
                "_blank"
            );
        }
    });

}


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
    fetch(`/api/novaposhta/cities`)
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


document.addEventListener('DOMContentLoaded', function () {
    showLoaderWithDelay();
    // const cart = @json($cart);
    const cart = window.cartData || [];

    const orderItemsContainer = document.getElementById('order-items');
    const totalPriceElement = document.getElementById('total-price');

    let totalOrderPrice = 0;

    cart.forEach(product => {
        const totalPrice = (product.actualPrice * product.quantity).toFixed(0);
        totalOrderPrice += parseFloat(totalPrice);

        const imageUrl = product.image ? product.image : '/images/no-image.png';

        const row = `
                <tr>
                    <td><img id="product-img" src="${imageUrl}" alt="${product.name}" style="width: 80px; height: 50px; object-fit: contain;"></td>
                    <td>${product.name}</td>
                    <td id="product-quantity">${product.quantity} шт</td>
<!--                    <td>${parseFloat(product.actualPrice).toFixed(0)} грн</td>-->
                    <td id="product-totalPrice">${totalPrice} грн</td>
                </tr>
            `;
        orderItemsContainer.innerHTML += row;
    });

    totalPriceElement.innerText = `${totalOrderPrice.toFixed(0)} грн`;
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
                    deliveryCostElement.textContent = `${cost} грн`;
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
                deliveryCostElement.textContent = '50 грн';
                toggleFields('ukrposhta');
            }
            else if (method === 'pickup') {
                deliveryCostElement.textContent = '0 грн';
                toggleFields('pickup');
            }
            else if (method === 'courier') {
                deliveryCostElement.textContent = '150 грн';
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
            discountElement.textContent = `${discount}% (-${discountAmount.toFixed(0)} грн)`;
        }
        else {
            discountElement.textContent = 'немає';
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
            totalAmountElement.textContent = `${finalAmount.toFixed(0)} грн`;
        }
        else {
            totalAmountElement.textContent = `${(totalPrice + deliveryCost).toFixed(0)} грн`;
        }

        fetch(`/user/deliveryCost`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
    const selectedPaymentButton = document.querySelector('.payment-method button.active');
    const methodText = selectedPaymentButton.querySelector('span')?.textContent?.trim();
    const payment_method = methodText === 'Visa/Mastercard' ? 'visa' : 'postpaid';

    if (!selectedShippingMethod) {
        alert('Будь ласка, оберіть метод доставки.');
        return;
    }

    if (!selectedPaymentButton) {
        alert('Будь ласка, оберіть метод оплати.');
        return;
    }

    const userId = window.userId;
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
        shippingCost = 50;
    }
    else if (selectedShippingMethod.getAttribute('data-method') === 'courier') {
        address = 'м.Хмельницький, ' + document.getElementById('courier-address').value;
        const deliveryErrorMessage4 = document.querySelector('.error-message-delivery4');

        if (!document.getElementById('courier-address').value.trim()) {
            deliveryErrorMessage4.style.display = 'block';
            window.scrollTo(0, 400);
            return;
        }
        shippingCost = 150;
    }
    else if (selectedShippingMethod.getAttribute('data-method') === 'pickup') {
        address = 'Самовивіз';
        shippingCost = 0;
    }

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

    fetch(`/user/cart/session`)
        .then(response => response.json())
        .then(products => {
            fetch(`/user/confirmOrder`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    shipping_method: selectedShippingMethod.getAttribute('data-method'),
                    payment_method,
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
                    if (data.payment_url) {
                        showToast('Замовлення успішно оформлено!', 'success');
                        setTimeout(() => {
                            window.location.href = data.payment_url;
                        }, 1500);
                    } else {
                        showToast('Замовлення успішно оформлено!', 'success');
                        setTimeout(() => {
                            window.location.href = '/user/main';
                        }, 1500);
                    }

                })
                .catch(error => {
                    console.error('Error:', error);
                });
        })
        .catch(error => {
            console.error('Не вдалося отримати товари з сесії:', error);
        });
});
