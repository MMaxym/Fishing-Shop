document.addEventListener("DOMContentLoaded", function () {
    document.body.addEventListener('click', function (e) {
        const icon = e.target.closest('.like-icon');
        if (!icon) return;

        const btn = icon.closest('.like-btn');
        if (!btn) return;

        e.preventDefault();
        e.stopPropagation();

        const productId = btn.dataset.id;

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

                const allButtons = document.querySelectorAll(`.like-btn[data-id='${productId}']`);

                if (data.status === 'added') {
                    showToast('Товар додано в улюблені!', 'success');
                    allButtons.forEach(button => {
                        const icon = button.querySelector('.like-icon');
                        icon.setAttribute('src', icon.dataset.filled);
                        button.classList.add('liked');
                    });
                    updateFavoritesAndRecently();
                } else if (data.status === 'removed') {
                    showToast('Товар видалено з улюблених!', 'info');
                    allButtons.forEach(button => {
                        const icon = button.querySelector('.like-icon');
                        icon.setAttribute('src', icon.dataset.outline);
                        button.classList.remove('liked');
                    });
                    updateFavoritesAndRecently();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
});

function updateFavoritesAndRecently() {
    fetch('/user/favoriteProducts', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            document.getElementById('favorite-products-container').innerHTML = data.favorites;
            document.getElementById('recently-products-scroll-container').innerHTML = data.recently;
        })
        .catch(error => {
            console.error('Помилка при оновленні товарів:', error);
        });
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
                        updateFavoritesAndRecently();
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
                        updateFavoritesAndRecently();
                    }

                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
});

