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
                } else if (data.status === 'removed') {
                    showToast('Товар видалено з улюблених!', 'info');
                    allButtons.forEach(button => {
                        const icon = button.querySelector('.like-icon');
                        icon.setAttribute('src', icon.dataset.outline);
                        button.classList.remove('liked');
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
});

function loadMoreProducts() {
    currentPage++;

    fetch(`/user/categoryTailSpinners?page=${currentPage}`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(data, 'text/html');

            const newProductCards = doc.querySelectorAll('.product-card');
            const cardsContainer = document.querySelector('.products-cards');

            newProductCards.forEach(card => cardsContainer.appendChild(card));

            document.querySelector('#itemsShown').innerText = cardsContainer.children.length;

            if (!doc.querySelector('#loadMore')) {
                document.querySelector('#loadMore').style.display = 'none';
            }
        })
        .catch(error => console.error('Error loading more products:', error));
}

const priceRangeSlider = document.getElementById('priceRange');
const minPriceInput = document.getElementById('minPriceInput');
const maxPriceInput = document.getElementById('maxPriceInput');

noUiSlider.create(priceRangeSlider, {
    start: [minPrice, maxPrice],
    connect: true,
    range: {
        'min': minPrice,
        'max': maxPrice
    },
    step: 1,
});

$(document).ready(function() {
    let params = new URLSearchParams(document.location.search);
    let max = params.get("max_price");
    let min = params.get("min_price");

    priceRangeSlider.noUiSlider.set([min, max]);

    $('#maxPriceInput').on("change", function(){
        let params = new URLSearchParams(document.location.search);

        let min = params.get("min_price");
        let max = $('#maxPriceInput').val();

        priceRangeSlider.noUiSlider.set([min, max]);
        applyFilters();
    } );

    $('#minPriceInput').on("change", function(){
        let params = new URLSearchParams(document.location.search);

        let min = $('#minPriceInput').val();
        let max = params.get("max_price");

        priceRangeSlider.noUiSlider.set([min, max]);
        applyFilters();
    } );
});

priceRangeSlider.noUiSlider.on('update', function (values, handle) {
    if (handle === 0) {
        minPriceInput.value = parseInt(values[0]);
    } else {
        maxPriceInput.value = parseInt(values[1]);
    }
});

priceRangeSlider.noUiSlider.on('change', function (values, handle) {
    applyFilters();
});

function resetSort() {
    const sortSelect = document.getElementById('sort');
    sortSelect.value = 'none';

    applyFilters();
}

function applyFilters() {
    const sort = document.getElementById('sort').value;
    const minPrice = minPriceInput.value;
    const maxPrice = maxPriceInput.value;

    const params = new URLSearchParams({
        sort: sort,
        min_price: minPrice,
        max_price: maxPrice,
        page: 1
    });

    fetch(`${window.location.pathname}?${params.toString()}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error("Помилка завантаження товарів");
            }
            return response.text();
        })
        .then(html => {
            const data = new DOMParser().parseFromString(html, 'text/html');

            const newCards = data.querySelector('.products-cards')?.innerHTML;
            const newPagination = data.querySelector('.pagination')?.innerHTML;
            const newPositionInfo = data.querySelector('.position-info')?.innerHTML;
            const newLoadMore = data.querySelector('#loadMore');

            document.querySelector('.products-cards').innerHTML = newCards || '';
            document.querySelector('.pagination').innerHTML = newPagination || '';
            document.querySelector('.position-info').innerHTML = newPositionInfo || '';

            const existingLoadMore = document.querySelector('#loadMore');
            if (newLoadMore) {
                if (existingLoadMore) {
                    existingLoadMore.replaceWith(newLoadMore);
                } else {
                    document.querySelector('.position-info')?.after(newLoadMore);
                }
            } else if (existingLoadMore) {
                existingLoadMore.remove();
            }

            currentPage = 1;

            history.pushState({}, '', `${window.location.pathname}?${params.toString()}`);

            window.scrollTo({ top: 0, behavior: 'smooth' });
        })
        .catch(error => {
            console.error(error);
        });
}

function resetFilters() {
    minPriceInput.value = 0;
    maxPriceInput.value = 1000;
    priceRangeSlider.noUiSlider.set([0, 1000]);

    document.getElementById('sort').value = 'none';

    const url = `?page=1&sort=none&min_price=0&max_price=1000`;

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'html',
        success: function (data) {
            const newCards = $(data).find('.products-cards').html();
            const newPagination = $(data).find('.pagination').html();
            const newPositionInfo = $(data).find('.position-info').html();
            const newLoadMore = $(data).find('#loadMore').first();

            $('.products-cards').html(newCards);
            $('.pagination').html(newPagination);
            $('.position-info').html(newPositionInfo);

            if (newLoadMore.length) {
                if ($('#loadMore').length) {
                    $('#loadMore').replaceWith(newLoadMore);
                } else {
                    $('.position-info').after(newLoadMore);
                }
            } else {
                $('#loadMore').remove();
            }

            currentPage = 1;

            history.pushState(null, '', url);
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        },
        error: function () {
            showToast('Помилка при скиданні фільтрів.', 'error');
        }
    });
}

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    const url = $(this).attr('href');

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'html',
        success: function (data) {
            const newCards = $(data).find('.products-cards').html();
            const newPagination = $(data).find('.pagination').html();
            const newPositionInfo = $(data).find('.position-info').html();
            const newLoadMore = $(data).find('#loadMore').first();

            $('.products-cards').html(newCards);
            $('.pagination').html(newPagination);
            $('.position-info').html(newPositionInfo);

            if (newLoadMore.length) {
                if ($('#loadMore').length) {
                    $('#loadMore').replaceWith(newLoadMore);
                } else {
                    $('.position-info').after(newLoadMore);
                }
            } else {
                $('#loadMore').remove();
            }

            const urlParams = new URLSearchParams(new URL(url, window.location.origin).search);
            currentPage = parseInt(urlParams.get('page')) || 1;
            history.pushState(null, '', url);

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        },
        error: function () {
            showToast('Помилка при переході між сторінками.', 'error');
        }
    });
});

$(document).on('click', '#loadMore', function(e) {
    e.preventDefault();
    loadMoreProducts();
});
