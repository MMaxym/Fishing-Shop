document.querySelectorAll('.quantity-increase, .quantity-decrease').forEach(button => {
    button.addEventListener('click', async () => {
        const container = button.closest('.cart-item-quantity');
        const id = container.dataset.id;
        let quantity = parseInt(container.querySelector('span').innerText);

        quantity += button.classList.contains('quantity-increase') ? 1 : -1;
        if (quantity < 1) quantity = 1;

        const response = await fetch('/user/cart/update-quantity', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id, quantity }),
        });

        if (response.status === 400) {
            return response.json().then(data => {
                showToast(data.message, 'error');
            });
        }

        const result = await response.json();

        if (result.success) {
            updateCartUI(id, quantity);
            updateCartSummary();
        }
        else {
            alert('Помилка при оновленні кількості');
        }
    });
});

function updateCartUI(id, quantity) {
    const row = document.querySelector(`.cart-item[data-id='${id}']`);
    if (!row) return;

    const priceElement = row.querySelector('.cart-item-price');
    const quantityElement = row.querySelector('.quantity-value');

    const price = parseFloat(priceElement?.dataset.actualPrice);
    if (!isNaN(price)) {
        quantityElement.innerText = quantity;
        const total = price * quantity;
        row.querySelector('.cart-item-total').innerText = `${Math.round(total).toLocaleString()} грн`;
    }
}

function updateCartSummary() {
    let totalPrice = 0;
    let totalActualPrice = 0;

    document.querySelectorAll('.cart-item').forEach(row => {
        const quantity = parseInt(row.querySelector('.quantity-value').innerText);
        const price = parseFloat(row.dataset.price);
        const actualPrice = parseFloat(row.dataset.actualPrice);

        if (!isNaN(price) && !isNaN(actualPrice) && !isNaN(quantity)) {
            totalPrice += price * quantity;
            totalActualPrice += actualPrice * quantity;
        }
    });

    const discount = totalPrice - totalActualPrice;

    document.getElementById('summary-total-price').innerText = `${Math.round(totalPrice).toLocaleString()} грн`;
    document.getElementById('summary-discount').innerText = `- ${Math.round(discount).toLocaleString()} грн`;
    document.getElementById('summary-final-price').innerText = `${Math.round(totalActualPrice).toLocaleString()} грн`;
}

document.querySelectorAll('.cart-item-remove').forEach(button => {
    button.addEventListener('click', function () {
        const cartItem = this.closest('.cart-item');
        const itemId = cartItem.dataset.id;

        fetch(`/user/cart/remove/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showToast(`Товар успішно видалено з кошика!`, 'success');
                    cartItem.remove();
                    updateCartSummary();

                    const remainingItems = document.querySelectorAll('.cart-item').length;
                    if (remainingItems === 0) {
                        location.reload();
                    }
                }
            })
            .catch(error => console.error('Помилка при видаленні:', error));
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const scrollContainer = document.getElementById('recently-products-scroll-container');
    let scrollSpeed = 0.5;
    function autoScroll() {

        scrollContainer.scrollLeft += scrollSpeed;

        if (scrollContainer.scrollLeft + scrollContainer.clientWidth >= scrollContainer.scrollWidth - 1) {
            scrollContainer.scrollLeft = 0;
        }

        requestAnimationFrame(autoScroll);
    }
    autoScroll();
});


document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.recently-like-btn .recently-like-icon').forEach(function (icon) {
        icon.addEventListener('click', function (e) {
            e.stopPropagation();

            const btn = icon.closest('.recently-like-btn');
            const productId = btn.dataset.id;
            const outlineSrc = icon.dataset.outline;
            const filledSrc = icon.dataset.filled;

            fetch(`/user/favorite-products/toggle/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 401) {
                            showToast('Щоб додати товар в улюблені, спочатку увійдіть в акаунт!', 'warning');
                            return;
                        }
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data) return;

                    if (data.status === 'added') {
                        showToast('Товар додано в улюблені!', 'success');
                        const allButtons = document.querySelectorAll(`.recently-like-btn[data-id='${productId}']`);
                        allButtons.forEach(button => {
                            const icon = button.querySelector('.recently-like-icon');
                            const filledSrc = icon.getAttribute('data-filled');
                            icon.setAttribute('src', filledSrc);
                            button.classList.add('liked');
                        });

                    }
                    else if (data.status === 'removed') {
                        showToast('Товар видалено з улюблених!', 'info');
                        const allButtons = document.querySelectorAll(`.recently-like-btn[data-id='${productId}']`);
                        allButtons.forEach(button => {
                            const icon = button.querySelector('.recently-like-icon');
                            const outlineSrc = icon.getAttribute('data-outline');
                            icon.setAttribute('src', outlineSrc);
                            button.classList.remove('liked');
                        });
                    }

                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
});
