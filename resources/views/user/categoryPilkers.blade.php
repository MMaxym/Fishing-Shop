@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/categoryPilkers.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.css" />
</head>

@section('content')
    <div class="container" style="max-width: 1600px;">
        @include('layouts.header-user')
        <div style="margin-top: 120px; margin-bottom: 100px; text-align: center;">
            <p class="navigate">
                <a href="{{ route('user.main') }}" class="breadcrumb-link">
                    <i class="fa fa-home"></i> Головна
                </a>
                >> Пількери
            </p>
            <h2 class="page-title">ПІЛЬКЕРИ</h2>

{{--            <div class="filter-container">--}}
{{--                <div class="filter-sort">--}}
{{--                    <label for="sort">Сортувати:</label>--}}
{{--                    <select id="sort" name="sort" onchange="applyFilters()">--}}
{{--                        <option value="none" {{ $sortOrder == 'none' ? 'selected' : '' }}>По замовчуванню</option>--}}
{{--                        <option value="low_to_high" {{ $sortOrder == 'low_to_high' ? 'selected' : '' }}>Від найнижчої ціни</option>--}}
{{--                        <option value="high_to_low" {{ $sortOrder == 'high_to_low' ? 'selected' : '' }}>Від найвищої ціни</option>--}}
{{--                        <option value="a_to_z" {{ $sortOrder == 'a_to_z' ? 'selected' : '' }}>Від A до Я</option>--}}
{{--                        <option value="z_to_a" {{ $sortOrder == 'z_to_a' ? 'selected' : '' }}>Від Я до A</option>--}}
{{--                    </select>--}}
{{--                    <button id="resetSortButton" class="filter-button" onclick="resetSort()">Скинути</button>--}}
{{--                </div>--}}

{{--                <div class="filter-price">--}}
{{--                    <label for="priceRange">Ціна:</label>--}}
{{--                    <div id="priceRange" style="margin: 20px 0;"></div>--}}
{{--                    <input type="number" id="minPriceInput" value="{{ $minPrice ?? 0 }}" oninput="syncMinPriceRange(this.value)" class="price-input">--}}
{{--                    <input type="number" id="maxPriceInput" value="{{ $maxPrice ?? 1000 }}" oninput="syncMaxPriceInput(this.value)" class="price-input">--}}
{{--                </div>--}}

{{--                <div class="filter-actions">--}}
{{--                    <button class="filter-button" onclick="applyFilters()">Застосувати фільтри</button>--}}
{{--                    <button class="filter-button" onclick="resetFilters()">Скинути фільтри</button>--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        @if($product->isDiscounted)
                            <div class="sale-icon">
                                <img src="{{ asset('images/sale-icon.png') }}" alt="Sale">
                            </div>
                        @elseif($product->isNew)
                            <div class="new-icon">
                                <img src="{{ asset('images/new-icon-2.png') }}" alt="New">
                            </div>
                        @endif

                    @if($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" alt="{{ $product->name }}" style="width: 220px; height: 170px;">
                        @else
                            <span id="notImage">Немає зображення</span>
                        @endif

                        <h3>{{ $product->name }} ({{ $product->size}}) - {{ $product->article }}</h3>

                        @if($product->discount)
                            @if($product->quantity == 0)
                                <p style="text-decoration: line-through; font-size: 14px;">
                                    {{ number_format($product->price, 2) }} грн
                                </p>
                                <p style="color: red;">
                                    {{ number_format($product->price * (1 - $product->discount->percentage / 100), 2) }} грн
                                </p>
                                <p style="color: red; font-weight: normal; font-size: 14px;">*Немає в наявності</p>
                            @elseif($product->quantity < 50)
                                    <p style="text-decoration: line-through; font-size: 14px;">
                                        {{ number_format($product->price, 2) }} грн
                                    </p>
                                    <p style="color: red;">
                                        {{ number_format($product->price * (1 - $product->discount->percentage / 100), 2) }} грн
                                    </p>
                                    <p style="color: #ff8800; font-weight: normal; font-size: 14px;">*Товар закінчується</p>
                            @else
                                    <p style="text-decoration: line-through; font-size: 14px; padding-top: 14px;">
                                        {{ number_format($product->price, 2) }} грн
                                    </p>
                                    <p style="color: red; padding-bottom: 14px;">
                                        {{ number_format($product->price * (1 - $product->discount->percentage / 100), 2) }} грн
                                    </p>
                            @endif
                        @else
                            @if($product->quantity == 0)
                                <p style="padding-top: 15px; padding-bottom: 5px;">{{ number_format($product->price, 2) }} грн</p>
                                <p style="color: red; font-weight: normal; font-size: 14px; padding-bottom: 7px;">*Немає в наявності</p>
                            @elseif($product->quantity < 50)
                                <p style="padding-top: 15px; padding-bottom: 5px;">{{ number_format($product->price, 2) }} грн</p>
                                <p style="color: #ff8800; font-weight: normal; font-size: 14px; padding-bottom: 7px;">*Товар закінчується</p>
                            @else
                                <p style="padding-top: 26px; padding-bottom: 27px;">{{ number_format($product->price, 2) }} грн</p>
                            @endif
                        @endif
                        <button>
                            <i class="fas fa-shopping-cart"></i> Купити
                        </button>
                    </div>
                @endforeach
            </div>

            <div class="position-info">
                Позиції: <span id="itemsShown">{{ $itemsShown }}</span> з {{ $totalItems }}
            </div>

            @if ($products->hasMorePages())
                <button id="loadMore" onclick="loadMoreProducts()" style="margin-top: 20px;">
                    <i class="fas fa-sync" style="margin-right: 5px;"></i> Показати ще
                </button>
            @endif


            <div class="pagination">
                <ul class="pagination-links" style="padding: 0;">
                    {{ $products->links('vendor.pagination.default') }}
                </ul>
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.js"></script>
    <script>
        let currentPage = {{ $products->currentPage() }};
        let totalItems = {{ $totalItems }};

        function loadMoreProducts() {
            currentPage++;

            fetch(`{{ route('user.categoryPilkers') }}?page=${currentPage}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(data => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const newProducts = doc.querySelector('.products-grid').innerHTML;

                    document.querySelector('.products-grid').insertAdjacentHTML('beforeend', newProducts);

                    const newCount = document.querySelector('.products-grid').children.length;
                    document.querySelector('#itemsShown').innerText = newCount;

                    if (!doc.querySelector('#loadMore')) {
                        document.querySelector('#loadMore').style.display = 'none';
                    }
                })
                .catch(error => console.error('Error loading more products:', error));
        }


        // function resetSort() {
        //     const sortSelect = document.getElementById('sort');
        //     sortSelect.value = 'none';
        //     applyFilters();
        // }
        //
        //
        // const priceRangeSlider = document.getElementById('priceRange');
        // const minPriceInput = document.getElementById('minPriceInput');
        // const maxPriceInput = document.getElementById('maxPriceInput');
        //
        // noUiSlider.create(priceRangeSlider, {
        //     start: [minPriceInput.value, maxPriceInput.value],
        //     connect: true,
        //     range: {
        //         'min': 0,
        //         'max': 1000
        //     },
        //     step: 10,
        //     format: {
        //         to: function (value) {
        //             return Math.round(value);
        //         },
        //         from: function (value) {
        //             return Number(value);
        //         }
        //     }
        // });
        //
        // priceRangeSlider.noUiSlider.on('update', function (values, handle) {
        //     if (handle === 0) {
        //         minPriceInput.value = values[0];
        //     } else {
        //         maxPriceInput.value = values[1];
        //     }
        // });
        //
        // function applyFilters() {
        //     const sort = document.getElementById('sort').value;
        //     const minPrice = minPriceInput.value;
        //     const maxPrice = maxPriceInput.value;
        //     const url = `?sort=${sort}&min_price=${minPrice}&max_price=${maxPrice}`;
        //     window.location.href = url;
        // }
        //
        // function resetFilters() {
        //     minPriceInput.value = 0;
        //     maxPriceInput.value = 1000;
        //     priceRangeSlider.noUiSlider.set([0, 1000]);
        //
        //     const sort = document.getElementById('sort').value;
        //     window.location.href = `?sort=${sort}&min_price=0&max_price=1000`;
        // }


    </script>

    @include('layouts.footer-user')

@endsection
