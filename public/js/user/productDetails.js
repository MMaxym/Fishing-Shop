document.addEventListener('DOMContentLoaded', () => {
    const sliderWrapper = document.querySelector('.slider-wrapper');
    const slides = document.querySelectorAll('.slider-image');
    const dots = document.querySelectorAll('.dot');
    let currentIndex = 0;

    function showSlide(index) {
        if (index < 0) index = slides.length - 1;
        if (index >= slides.length) index = 0;
        sliderWrapper.style.transform = `translateX(-${index * 100}%)`;
        currentIndex = index;

        dots.forEach(dot => dot.classList.remove('active'));
        dots[index].classList.add('active');
    }

    document.querySelector('.prev-btn').addEventListener('click', () => showSlide(currentIndex - 1));
    document.querySelector('.next-btn').addEventListener('click', () => showSlide(currentIndex + 1));

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            const index = parseInt(dot.dataset.index);
            showSlide(index);
        });
    });

    showSlide(0);
});


let quantity = 1;
const qtyValue = document.getElementById("qty-value");

function increaseQty() {
    quantity++;
    qtyValue.textContent = quantity;
}

function decreaseQty() {
    if (quantity > 1) {
        quantity--;
        qtyValue.textContent = quantity;
    }
}


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


document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.like-btn .like-icon').forEach(function (icon) {
        icon.addEventListener('click', function (e) {
            e.stopPropagation();

            const btn = icon.closest('.like-btn');
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
                        const allButtons = document.querySelectorAll(`.like-btn[data-id='${productId}']`);
                        allButtons.forEach(button => {
                            const icon = button.querySelector('.like-icon');
                            const filledSrc = icon.getAttribute('data-filled');
                            icon.setAttribute('src', filledSrc);
                            button.classList.add('liked');
                        });

                    }
                    else if (data.status === 'removed') {
                        showToast('Товар видалено з улюблених!', 'info');
                        const allButtons = document.querySelectorAll(`.like-btn[data-id='${productId}']`);
                        allButtons.forEach(button => {
                            const icon = button.querySelector('.like-icon');
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

function updateCartBadge(count) {
    let badge = document.querySelector('.cart-badge');
    if (!badge && count > 0) {
        badge = document.createElement('span');
        badge.classList.add('cart-badge');
        document.querySelector('.link-icon').appendChild(badge);
    }

    if (count > 0) {
        badge.textContent = count;
        badge.style.display = 'inline';
    } else if (badge) {
        badge.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const addToCartBtn = document.querySelector('.add-to-cart-btn');

    if (!addToCartBtn) return;

    addToCartBtn.addEventListener('click', function () {

        const quantity = parseInt(document.getElementById('qty-value').innerText);

        const product = {
            id: addToCartBtn.dataset.id,
            name: addToCartBtn.dataset.name,
            article: addToCartBtn.dataset.article,
            size: addToCartBtn.dataset.size,
            price: parseFloat(addToCartBtn.dataset.price),
            actualPrice: parseFloat(addToCartBtn.dataset.actualPrice),
            quantity: quantity,
            discountPercentage: addToCartBtn.dataset.discountPercentage,
            discountEndDate: addToCartBtn.dataset.discountEndDate,
            image: addToCartBtn.dataset.image
        };

        fetch('/user/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ product })
        })
            .then(response => {
                if (response.status === 401) {
                    showToast('Щоб додати товар в кошик, спочатку увійдіть в акаунт!', 'warning');
                    return;
                }
                if (response.status === 400) {
                    return response.json().then(data => {
                        showToast(data.message, 'error');
                    });
                }
                return response.json();
            })

            .then(data => {
                if (data?.message === 'added') {
                    showToast(`Товар успішно додано до кошика! <br> Всього товарів у кошику: ${data.cartCount}`, 'success');
                    updateCartBadge(data.cartCount);
                }
                else if (data?.message === 'updated') {
                    showToast(`Товар вже є у кошику, тому кількість збільшено на ${data.addedQuantity} <br> Всього товарів у кошику: ${data.cartCount}`, 'success');
                    updateCartBadge(data.cartCount);
                }
            })
            .catch(error => {
                console.error('Помилка при додаванні в кошик:', error);
                showToast('Сталася помилка при додаванні товару в кошик.', 'error');
            });
    });
});
