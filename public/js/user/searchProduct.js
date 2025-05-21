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

