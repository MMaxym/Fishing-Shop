@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/saleProducts.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.css" />
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
                        </li>
                        <li class="current-product">Акційні товари</li>
                    </ul>
                </nav>
            </div>
        </section>
        <section class="main-row">
            <div class="products-wrapper">
                <h2 class="row-title" id="main-title">Акційні товари</h2>
                <div class="products-main-section">
                    <div class="filters-section">
                        <h2 class="filters-title">Фільтрування</h2>
                        <div class="sort-section">
                            <div class="filter-sort">
                                <div class="filter-title-row">
                                    <label for="sort">
                                        Сортування
                                        <i class="fas fa-sort-amount-up" ></i>
                                    </label>
                                    <button id="resetSortButton" class="filter-button" onclick="resetSort()">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                </div>
                                <select id="sort" name="sort" onchange="applyFilters()">
                                    <option value="none" {{ $sortOrder == 'none' ? 'selected' : '' }}>По замовчуванню</option>
                                    <option value="low_to_high" {{ $sortOrder == 'low_to_high' ? 'selected' : '' }}>Від найнижчої ціни</option>
                                    <option value="high_to_low" {{ $sortOrder == 'high_to_low' ? 'selected' : '' }}>Від найвищої ціни</option>
                                    <option value="a_to_z" {{ $sortOrder == 'a_to_z' ? 'selected' : '' }}>Від A до Я</option>
                                    <option value="z_to_a" {{ $sortOrder == 'z_to_a' ? 'selected' : '' }}>Від Я до A</option>
                                </select>
                            </div>
                        </div>
                        <div class="sort-section">
                            <div class="filter-category">
                                <div class="filter-title-row">
                                    <label for="category-filter">
                                        Категорії
                                        <i class="fas fa-filter"></i>
                                    </label>
                                    <button id="resetCategoryButton" class="filter-button" onclick="resetCategory()" style="height: 46px;">
                                        <i class="fas fa-redo" style="margin-right: 0;"></i>
                                    </button>
                                </div>
                                <div id="sort2-wrapper">
                                    <label class="row-radio">
                                        <input class="custom-radio" type="radio" name="sort2" value="none" {{ $category == 'none' ? 'checked' : '' }} onchange="applyFilters()">
                                        <span>Усі товари</span>
                                    </label>
                                    <label class="row-radio">
                                        <input class="custom-radio" type="radio" name="sort2" value="1" {{ $category == '1' ? 'checked' : '' }} onchange="applyFilters()">
                                        <span>Балансири</span>
                                    </label>
                                    <label class="row-radio">
                                        <input class="custom-radio" type="radio" name="sort2" value="2" {{ $category == '2' ? 'checked' : '' }} onchange="applyFilters()">
                                        <span>Тейл-спінери</span>
                                    </label>
                                    <label class="row-radio">
                                        <input class="custom-radio" type="radio" name="sort2" value="3" {{ $category == '3' ? 'checked' : '' }} onchange="applyFilters()">
                                        <span>Пількери</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="sort-section" id="sort-section-price">
                            <div class="filter-price">
                                <div class="filter-title-row">
                                    <label for="priceRange">Ціна ₴</label>
                                    <button class="filter-button" onclick="resetFilters()">
                                        <i class="fas fa-redo" style="margin-right: 0;"></i>
                                    </button>
                                </div>
                                <div id="priceRange"></div>
                                <div class="column-price">
                                    <div class="row-price">
                                        <label for="minPriceInput">Мін:</label>
                                        <input type="number" id="minPriceInput" value="{{ $minPrice ?? 0 }}" oninput="syncMinPriceRange(this.value)" class="price-input">
                                    </div>
                                    <div class="row-price">
                                        <label for="maxPriceInput">Макс:</label>
                                        <input type="number" id="maxPriceInput" value="{{ $maxPrice ?? 1000 }}" oninput="syncMaxPriceInput(this.value)" class="price-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="productList">
                        @include('partials.sale-products', ['products' => $products])
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layouts.footer-user')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.js"></script>

    <script>
        let currentPage = {{ $products->currentPage() }};
        let totalItems = {{ $totalItems }};
        const minPrice = {{ $minPriceFromDB }};
        const maxPrice = {{ $maxPriceFromDB }};

    </script>

    <script src="{{ asset('js/user/saleProducts.js') }}"></script>

@endsection










{{--@extends('layouts.app')--}}

{{--<head>--}}
{{--    <link rel="stylesheet" href="{{ asset('css/user/saleProducts.css') }}">--}}
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.css" />--}}
{{--</head>--}}


{{--@section('content')--}}

{{--    <div class="container" style="max-width: 1600px;">--}}
{{--        @include('layouts.header-user')--}}
{{--        <div style="margin-top: 120px; margin-bottom: 100px; text-align: center;">--}}
{{--            <p class="navigate">--}}
{{--                <a href="{{ route('user.main') }}" class="breadcrumb-link">--}}
{{--                    <i class="fa fa-home"></i> Головна--}}
{{--                </a>--}}
{{--                > Акційні товари--}}
{{--            </p>--}}
{{--            <h2 class="page-title">АКЦІЙНІ ТОВАРИ</h2>--}}

{{--            <div class="filter-container">--}}
{{--                <div class="filter-sort">--}}
{{--                    <label for="sort">--}}
{{--                        <i class="fas fa-sort-amount-down" style="margin-right: 5px;"></i>--}}
{{--                        Сортувати:--}}
{{--                    </label>--}}
{{--                    <div class="row" style="margin-left: 0;">--}}
{{--                        <select id="sort" name="sort" onchange="applyFilters()" style="max-width: 200px; height: 46px; margin-right: 10px;">--}}
{{--                            <option value="none" {{ $sortOrder == 'none' ? 'selected' : '' }}>По замовчуванню</option>--}}
{{--                            <option value="low_to_high" {{ $sortOrder == 'low_to_high' ? 'selected' : '' }}>Від найнижчої ціни</option>--}}
{{--                            <option value="high_to_low" {{ $sortOrder == 'high_to_low' ? 'selected' : '' }}>Від найвищої ціни</option>--}}
{{--                            <option value="a_to_z" {{ $sortOrder == 'a_to_z' ? 'selected' : '' }}>Від A до Я</option>--}}
{{--                            <option value="z_to_a" {{ $sortOrder == 'z_to_a' ? 'selected' : '' }}>Від Я до A</option>--}}
{{--                        </select>--}}
{{--                        <button id="resetSortButton" class="filter-button" onclick="resetSort()" style="height: 46px;">--}}
{{--                            <i class="fas fa-redo" style="margin-right: 0;"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="filter-category">--}}
{{--                    <label for="category-filter">--}}
{{--                        <i class="fas fa-filter" style="margin-right: 5px;"></i>--}}
{{--                        Фільтрувати:--}}
{{--                    </label>--}}
{{--                    <div class="row" style="margin-left: 0;">--}}
{{--                        <select id="sort2" name="sort2" onchange="applyFilters()" style="max-width: 200px; height: 46px; margin-right: 10px;">--}}
{{--                            <option value="none" {{ $category == 'none' ? 'selected' : '' }}>Усі товари</option>--}}
{{--                            <option value="2" {{ $category == '2' ? 'selected' : '' }}>Тейл-спінери</option>--}}
{{--                            <option value="1" {{ $category == '1' ? 'selected' : '' }}>Балансири</option>--}}
{{--                            <option value="3" {{ $category == '3' ? 'selected' : '' }}>Пількери</option>--}}
{{--                        </select>--}}
{{--                        <button id="resetCategoryButton" class="filter-button" onclick="resetCategory()" style="height: 46px;">--}}
{{--                            <i class="fas fa-redo" style="margin-right: 0;"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="filter-price">--}}
{{--                    <div class="vr" style="height: 100px; width: 2px; background-color: #04396E; margin-left: 45px;"></div>--}}
{{--                    <div class="column" style="margin-left: 30px;">--}}
{{--                        <label for="priceRange" style="display: flex; align-items: center;">₴ Ціна:</label>--}}
{{--                        <div id="priceRange" style="margin: 20px 0;"></div>--}}
{{--                    </div>--}}
{{--                    <div class="column" style="margin-left: 50px;">--}}
{{--                        <div class="row">--}}
{{--                            <label for="minPriceInput">Мін:</label>--}}
{{--                            <label for="maxPriceInput" style="margin-left: 80px;">Макс:</label>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <input type="number" id="minPriceInput" value="{{ $minPrice ?? 0 }}" oninput="syncMinPriceRange(this.value)" class="price-input">--}}
{{--                            <input type="number" id="maxPriceInput" value="{{ $maxPrice ?? 1000 }}" oninput="syncMaxPriceInput(this.value)" class="price-input">--}}
{{--                            <button class="filter-button" onclick="resetFilters()" style="height: 46px; margin-right: 20px;">--}}
{{--                                <i class="fas fa-redo" style="margin-right: 0;"></i>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="products-grid">--}}
{{--                @foreach($products as $product)--}}
{{--                    <div class="product-card"--}}
{{--                         data-id="{{$product->id}}"--}}
{{--                         data-name="{{ $product->name }}"--}}
{{--                         data-size="{{ $product->size }}"--}}
{{--                         data-quantity="{{ $product->quantity }}"--}}
{{--                         data-description="{{ $product->description }}"--}}
{{--                         data-image="{{ $product->images->isNotEmpty() ? implode(',', $product->images->map(fn($img) => asset('storage/' . $img->image_url))->toArray()) : '' }}"--}}
{{--                         data-article="{{ $product->article }}"--}}
{{--                         data-price="{{ $product->price }}"--}}
{{--                         data-discounted-price="{{ $product->discount ? $product->discountedPrice() : $product->price }}"--}}
{{--                         data-actual-price="{{$product->actual_price}}">--}}

{{--                        @if($product->isDiscounted)--}}
{{--                            <div class="sale-icon">--}}
{{--                                <img src="{{ asset('images/sale-icon.png') }}" alt="Sale">--}}
{{--                            </div>--}}
{{--                        @endif--}}

{{--                        @if($product->images->isNotEmpty())--}}
{{--                            <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" alt="{{ $product->name }}" style="width: 220px; height: 170px;">--}}
{{--                        @else--}}
{{--                            <span id="notImage">Немає зображення</span>--}}
{{--                        @endif--}}

{{--                        <h3>{{ $product->name }} ({{ $product->size}}) - {{ $product->article }}</h3>--}}

{{--                        @if($product->discount)--}}
{{--                            @if($product->quantity == 0)--}}
{{--                                <p style="text-decoration: line-through; font-size: 14px;">--}}
{{--                                    {{ number_format($product->price, 2) }} грн--}}
{{--                                </p>--}}
{{--                                <p style="color: red;">--}}
{{--                                    {{ number_format($product->discountedPrice(), 2) }} грн--}}
{{--                                </p>--}}
{{--                                <p style="color: red; font-weight: normal; font-size: 14px;">*Немає в наявності</p>--}}
{{--                            @elseif($product->quantity < 50)--}}
{{--                                <p style="text-decoration: line-through; font-size: 14px;">--}}
{{--                                    {{ number_format($product->price, 2) }} грн--}}
{{--                                </p>--}}
{{--                                <p style="color: red;">--}}
{{--                                    {{ number_format($product->discountedPrice(), 2) }} грн--}}
{{--                                </p>--}}
{{--                                <p style="color: #ff8800; font-weight: normal; font-size: 14px;">*Товар закінчується</p>--}}
{{--                            @else--}}
{{--                                <p style="text-decoration: line-through; font-size: 14px; padding-top: 14px;">--}}
{{--                                    {{ number_format($product->price, 2) }} грн--}}
{{--                                </p>--}}
{{--                                <p style="color: red; padding-bottom: 14px;">--}}
{{--                                    {{ number_format($product->discountedPrice(), 2) }} грн--}}
{{--                                </p>--}}
{{--                            @endif--}}
{{--                        @else--}}
{{--                            @if($product->quantity == 0)--}}
{{--                                <p style="padding-top: 15px; padding-bottom: 5px;">{{ number_format($product->price, 2) }} грн</p>--}}
{{--                                <p style="color: red; font-weight: normal; font-size: 14px; padding-bottom: 7px;">*Немає в наявності</p>--}}
{{--                            @elseif($product->quantity < 50)--}}
{{--                                <p style="padding-top: 15px; padding-bottom: 5px;">{{ number_format($product->price, 2) }} грн</p>--}}
{{--                                <p style="color: #ff8800; font-weight: normal; font-size: 14px; padding-bottom: 7px;">*Товар закінчується</p>--}}
{{--                            @else--}}
{{--                                <p style="padding-top: 26px; padding-bottom: 27px;">{{ number_format($product->price, 2) }} грн</p>--}}
{{--                            @endif--}}
{{--                        @endif--}}
{{--                            <button class="open-modal">--}}
{{--                                <i class="fas fa-shopping-cart"></i> Купити--}}
{{--                            </button>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}

{{--            <div id="productModal" class="modal">--}}
{{--                <div class="modal-content">--}}
{{--                    <div class="panel">--}}
{{--                        <p id="modalProductQuantity" style="color: red; font-size: 18px; margin: 0"></p>--}}
{{--                        <span class="close">&times;</span>--}}
{{--                    </div>--}}
{{--                    <div class="content">--}}
{{--                        <div class="modal-left">--}}
{{--                            <button id="prevButton" class="slider-button" style="background-color: transparent; color: #04396e;">--}}
{{--                                <i class="fas fa-chevron-left" style="font-size:25px; margin: 0;"></i>--}}
{{--                            </button>--}}
{{--                            <div id="productSlider" class="slider">--}}
{{--                                <div class="slides">--}}
{{--                                    <img id="modalImage" src="" alt="Product Image" style="width: 100%;">--}}
{{--                                </div>--}}
{{--                                <div class="dots-container"></div>--}}
{{--                            </div>--}}
{{--                            <button id="nextButton" class="slider-button" style="background-color: transparent; color: #04396e;">--}}
{{--                                <i class="fas fa-chevron-right" style="font-size:25px; margin: 0;"></i>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        <div class="modal-right">--}}
{{--                            <div class="first">--}}
{{--                                <h3 id="modalProductName" style="color: #04396e;"></h3>--}}
{{--                                <h6 id="modalProductArticle" style="color: #989898;"></h6>--}}
{{--                                <p id="modalProductDescription" style="color: #2c73bb;"></p>--}}
{{--                                <div>--}}
{{--                                    <p style="font-size: 20px; color: #04396e;">Вага:</p>--}}
{{--                                    <p id="modalProductSize" style="font-size: 20px; color: #2c73bb;"></p>--}}
{{--                                </div>--}}
{{--                                <p style="font-size: 20px; color: #04396e; margin-top: 15px;" id="modalProductPrice"></p>--}}
{{--                                <p style="font-size: 25px; color: red; font-weight: bold;" id="modalProductDiscountedPrice"></p>--}}
{{--                            </div>--}}
{{--                            <div class="two">--}}
{{--                                <div class="price">--}}
{{--                                </div>--}}
{{--                                <div class="two-but">--}}
{{--                                    <div class="quantity-container" style="margin-bottom: 15px;">--}}
{{--                                        <div style="padding: 2px 12px; background-color: #2c73bb; color: white; cursor: pointer;" id="decreaseQuantity">-</div>--}}
{{--                                        <span id="quantity">1</span>--}}
{{--                                        <div style="padding: 2px 12px; background-color: #2c73bb; color: white; cursor: pointer;" id="increaseQuantity">+</div>--}}
{{--                                    </div>--}}
{{--                                    <button id="addToCart" style="padding: 7px 15px;">--}}
{{--                                        <i class="fas fa-plus-circle"></i> Додати в кошик--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="position-info">--}}
{{--                Позиції: <span id="itemsShown">{{ $itemsShown }}</span> з {{ $totalItems }}--}}
{{--            </div>--}}

{{--            @if ($products->hasMorePages())--}}
{{--                <button id="loadMore" onclick="loadMoreProducts()" style="margin-top: 20px;">--}}
{{--                    <i class="fas fa-sync" style="margin-right: 5px;"></i> Показати ще--}}
{{--                </button>--}}
{{--            @endif--}}


{{--            <div class="pagination">--}}
{{--                <ul class="pagination-links" style="padding: 0;">--}}
{{--                    {{ $products->links('vendor.pagination.default') }}--}}
{{--                </ul>--}}
{{--            </div>--}}

{{--            <div id="scrollToTop" class="scroll-to-top">--}}
{{--                <i class="fas fa-arrow-up"></i>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}

{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.js"></script>--}}
{{--    <script>--}}
{{--        let currentPage = {{ $products->currentPage() }};--}}
{{--        let totalItems = {{ $totalItems }};--}}

{{--        function loadMoreProducts() {--}}
{{--            currentPage++;--}}

{{--            fetch(`{{ route('user.categoryPilkers') }}?page=${currentPage}`)--}}
{{--                .then(response => {--}}
{{--                    if (!response.ok) {--}}
{{--                        throw new Error('Network response was not ok');--}}
{{--                    }--}}
{{--                    return response.text();--}}
{{--                })--}}
{{--                .then(data => {--}}
{{--                    const parser = new DOMParser();--}}
{{--                    const doc = parser.parseFromString(data, 'text/html');--}}
{{--                    const newProducts = doc.querySelector('.products-grid').innerHTML;--}}

{{--                    document.querySelector('.products-grid').insertAdjacentHTML('beforeend', newProducts);--}}

{{--                    const newCount = document.querySelector('.products-grid').children.length;--}}
{{--                    document.querySelector('#itemsShown').innerText = newCount;--}}

{{--                    if (!doc.querySelector('#loadMore')) {--}}
{{--                        document.querySelector('#loadMore').style.display = 'none';--}}
{{--                    }--}}
{{--                })--}}
{{--                .catch(error => console.error('Error loading more products:', error));--}}
{{--        }--}}

{{--        const priceRangeSlider = document.getElementById('priceRange');--}}
{{--        const minPriceInput = document.getElementById('minPriceInput');--}}
{{--        const maxPriceInput = document.getElementById('maxPriceInput');--}}

{{--        const minPrice = {{ $minPriceFromDB }};--}}
{{--        const maxPrice = {{ $maxPriceFromDB }};--}}

{{--        noUiSlider.create(priceRangeSlider, {--}}
{{--            start: [minPrice, maxPrice],--}}
{{--            connect: true,--}}
{{--            range: {--}}
{{--                'min': minPrice,--}}
{{--                'max': maxPrice--}}
{{--            },--}}
{{--            step: 1,--}}
{{--        });--}}

{{--        $(document).ready(function() {--}}
{{--            let params = new URLSearchParams(document.location.search);--}}
{{--            let max = params.get("max_price");--}}
{{--            let min = params.get("min_price");--}}

{{--            priceRangeSlider.noUiSlider.set([min, max]);--}}


{{--            $('#maxPriceInput').on("change", function(){--}}
{{--                let params = new URLSearchParams(document.location.search);--}}

{{--                let min = params.get("min_price");--}}
{{--                let max = $('#maxPriceInput').val();--}}

{{--                priceRangeSlider.noUiSlider.set([min, max]);--}}
{{--                applyFilters();--}}
{{--            } );--}}

{{--            $('#minPriceInput').on("change", function(){--}}
{{--                let params = new URLSearchParams(document.location.search);--}}

{{--                let min = $('#minPriceInput').val();--}}
{{--                let max = params.get("max_price");--}}

{{--                priceRangeSlider.noUiSlider.set([min, max]);--}}
{{--                applyFilters();--}}
{{--            } );--}}
{{--        });--}}

{{--        priceRangeSlider.noUiSlider.on('update', function (values, handle) {--}}
{{--            if (handle === 0) {--}}
{{--                minPriceInput.value = values[0];--}}
{{--            } else {--}}
{{--                maxPriceInput.value = values[1];--}}
{{--            }--}}
{{--        });--}}

{{--        priceRangeSlider.noUiSlider.on('change', function (values, handle) {--}}
{{--            applyFilters();--}}
{{--        });--}}

{{--        function resetSort() {--}}
{{--            const sortSelect = document.getElementById('sort');--}}
{{--            const categorySelect = document.getElementById('sort2');--}}
{{--            sortSelect.value = 'none';--}}
{{--            categorySelect.value = 'none';--}}
{{--            applyFilters();--}}
{{--        }--}}

{{--        function applyFilters() {--}}
{{--            const sort = document.getElementById('sort').value;--}}
{{--            const category = document.getElementById('sort2').value;--}}
{{--            const minPrice = minPriceInput.value;--}}
{{--            const maxPrice = maxPriceInput.value;--}}
{{--            const url = `?sort=${sort}&category=${category}&min_price=${minPrice}&max_price=${maxPrice}`;--}}
{{--            window.location.href = url;--}}
{{--        }--}}

{{--        function resetCategory() {--}}
{{--            document.getElementById('sort2').value = 'none';--}}
{{--            applyFilters();--}}
{{--        }--}}


{{--        function resetFilters() {--}}
{{--            minPriceInput.value = 0;--}}
{{--            maxPriceInput.value = 1000;--}}
{{--            priceRangeSlider.noUiSlider.set([0, 1000]);--}}

{{--            const sort = document.getElementById('sort').value;--}}
{{--            const category = document.getElementById('sort2').value;--}}
{{--            window.location.href = `?sort=${sort}&min_price=0&max_price=1000&category=${category}`;--}}
{{--        }--}}

{{--        document.addEventListener('DOMContentLoaded', function() {--}}
{{--            const modal = document.getElementById('productModal');--}}
{{--            const closeModal = document.getElementsByClassName('close')[0];--}}
{{--            const buyButtons = document.querySelectorAll('.product-card button.open-modal');--}}

{{--            buyButtons.forEach(button => {--}}
{{--                const productCard = button.closest('.product-card');--}}

{{--                button.addEventListener('click', function(event) {--}}
{{--                    event.stopPropagation();--}}
{{--                    openModal(productCard);--}}
{{--                });--}}

{{--                productCard.addEventListener('click', function() {--}}
{{--                    openModal(productCard);--}}
{{--                });--}}
{{--            });--}}

{{--            function openModal(productCard) {--}}
{{--                const productId = productCard.getAttribute('data-id');--}}
{{--                const productName = productCard.getAttribute('data-name');--}}
{{--                const productDescription = productCard.getAttribute('data-description');--}}
{{--                const productSize = productCard.getAttribute('data-size');--}}
{{--                const productArticle = productCard.getAttribute('data-article');--}}
{{--                const productPrice = parseFloat(productCard.getAttribute('data-price'));--}}
{{--                const discountedPrice = parseFloat(productCard.getAttribute('data-discounted-price'));--}}
{{--                const actualPrice = parseFloat(productCard.getAttribute('data-actual-price'));--}}
{{--                let productQuantity = parseInt(productCard.getAttribute('data-quantity'));--}}

{{--                const images = productCard.getAttribute('data-image').split(',').map(img => img.trim());--}}

{{--                document.getElementById('modalProductName').innerText = productName;--}}
{{--                document.getElementById('modalProductDescription').innerText = productDescription;--}}
{{--                document.getElementById('modalProductSize').innerText = productSize + " г";--}}
{{--                document.getElementById('modalProductPrice').innerText = productPrice + " грн";--}}
{{--                document.getElementById('modalProductDiscountedPrice').innerText = discountedPrice + " грн";--}}
{{--                document.getElementById('modalProductArticle').innerText = "Артикул: " + productArticle;--}}
{{--                document.getElementById('modalProductQuantity').innerText = productQuantity;--}}

{{--                const priceElement = document.getElementById('modalProductPrice');--}}
{{--                const discountedPriceElement = document.getElementById('modalProductDiscountedPrice');--}}

{{--                if (productPrice !== discountedPrice) {--}}
{{--                    priceElement.innerText = productPrice + " грн";--}}
{{--                    priceElement.style.fontSize = '20px';--}}
{{--                    priceElement.style.textDecoration = 'line-through';--}}
{{--                    priceElement.style.color = '#04396e';--}}
{{--                    priceElement.style.marginTop = '15px';--}}

{{--                    discountedPriceElement.innerText = discountedPrice + " грн";--}}
{{--                    discountedPriceElement.style.fontSize = '25px';--}}
{{--                    discountedPriceElement.style.color = 'red';--}}
{{--                    discountedPriceElement.style.fontWeight = 'bold';--}}
{{--                } else {--}}
{{--                    priceElement.innerText = productPrice + " грн";--}}
{{--                    priceElement.style.fontSize = '25px';--}}
{{--                    priceElement.style.color = '#04396e';--}}
{{--                    priceElement.style.marginTop = '15px';--}}
{{--                    priceElement.style.textDecoration = 'none';--}}
{{--                    discountedPriceElement.innerText = '';--}}
{{--                }--}}

{{--                if (productQuantity === 0) {--}}
{{--                    document.getElementById('modalProductQuantity').innerText = '*Немає в наявності';--}}
{{--                    document.getElementById('modalProductQuantity').style.color = 'red';--}}
{{--                } else if (productQuantity < 50) {--}}
{{--                    document.getElementById('modalProductQuantity').innerText = '*Товар закінчується';--}}
{{--                    document.getElementById('modalProductQuantity').style.color = '#ff8800';--}}
{{--                } else {--}}
{{--                    document.getElementById('modalProductQuantity').innerText = '';--}}
{{--                    document.getElementById('modalProductQuantity').style.color = '';--}}
{{--                }--}}

{{--                let currentIndex = 0;--}}
{{--                let quantity = 1;--}}

{{--                function updateImage() {--}}
{{--                    document.getElementById('modalImage').src = images[currentIndex];--}}
{{--                    updateDots();--}}
{{--                }--}}

{{--                const dotsContainer = document.querySelector('.dots-container');--}}
{{--                dotsContainer.innerHTML = '';--}}
{{--                images.forEach((_, index) => {--}}
{{--                    const dot = document.createElement('span');--}}
{{--                    dot.classList.add('dot');--}}
{{--                    dot.addEventListener('click', function() {--}}
{{--                        currentIndex = index;--}}
{{--                        updateImage();--}}
{{--                    });--}}
{{--                    dotsContainer.appendChild(dot);--}}
{{--                });--}}

{{--                function updateDots() {--}}
{{--                    const dots = document.querySelectorAll('.dot');--}}
{{--                    dots.forEach((dot, index) => {--}}
{{--                        if (index === currentIndex) {--}}
{{--                            dot.classList.add('active');--}}
{{--                        } else {--}}
{{--                            dot.classList.remove('active');--}}
{{--                        }--}}
{{--                    });--}}
{{--                }--}}

{{--                document.getElementById('prevButton').onclick = function() {--}}
{{--                    currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1;--}}
{{--                    updateImage();--}}
{{--                };--}}

{{--                document.getElementById('nextButton').onclick = function() {--}}
{{--                    currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0;--}}
{{--                    updateImage();--}}
{{--                };--}}

{{--                updateImage();--}}

{{--                document.getElementById('quantity').innerText = quantity;--}}

{{--                document.getElementById('decreaseQuantity').onclick = function() {--}}
{{--                    if (quantity > 1) {--}}
{{--                        quantity--;--}}
{{--                        document.getElementById('quantity').innerText = quantity;--}}
{{--                    }--}}
{{--                };--}}

{{--                document.getElementById('increaseQuantity').onclick = function() {--}}
{{--                    if (quantity < productQuantity) {--}}
{{--                        quantity++;--}}
{{--                        document.getElementById('quantity').innerText = quantity;--}}
{{--                    } else {--}}
{{--                        alert('Ви не можете додати більше товарів, ніж є в наявності.');--}}
{{--                    }--}}
{{--                };--}}

{{--                const addToCartButton = document.getElementById('addToCart');--}}

{{--                addToCartButton.onclick = function() {--}}

{{--                    const userId = '{{ auth()->user() ? auth()->user()->id : "None" }}';--}}

{{--                    if (userId === "None") {--}}
{{--                        alert(`Ви не увійшли в акаунт. \nДля подальших дій авторизуйтесь на сайті.`);--}}
{{--                        return;--}}
{{--                    }--}}

{{--                    if (productQuantity === 0) {--}}
{{--                        alert(`На жаль, даного товару немає в наявності. \nВибачте за незручності.`);--}}
{{--                    }--}}
{{--                    else {--}}
{{--                        let cart = JSON.parse(localStorage.getItem(`cart_${userId}`)) || [];--}}

{{--                        const product = {--}}
{{--                            id: productId,--}}
{{--                            name: productName,--}}
{{--                            description: productDescription,--}}
{{--                            size: productSize,--}}
{{--                            article: productArticle,--}}
{{--                            price: productPrice,--}}
{{--                            actualPrice: actualPrice,--}}
{{--                            quantity: quantity,--}}
{{--                            quantityDB: productQuantity,--}}
{{--                            images: images,--}}
{{--                            dateAdded: new Date().getTime()--}}
{{--                        };--}}

{{--                        const existingProduct = cart.find(item => item.article === product.article && item.size === product.size);--}}

{{--                        if (existingProduct) {--}}
{{--                            existingProduct.quantity += quantity;--}}
{{--                            alert(`Товар ${productName} вже є у вашому кошику. \nТому кількість даного товару збільшено на ${quantity}. \nТепер у кошику ${existingProduct.quantity}.`);--}}
{{--                        } else {--}}
{{--                            cart.push(product);--}}
{{--                            alert(`Товар ${productName} додано в кошик з кількістю ${quantity}`);--}}
{{--                        }--}}

{{--                        localStorage.setItem(`cart_${userId}`, JSON.stringify(cart));--}}

{{--                        modal.style.display = 'none';--}}
{{--                    }--}}
{{--                };--}}

{{--                modal.style.display = 'block';--}}
{{--            }--}}

{{--            closeModal.onclick = function() {--}}
{{--                modal.style.display = 'none';--}}
{{--            };--}}

{{--            window.onclick = function(event) {--}}
{{--                if (event.target === modal) {--}}
{{--                    modal.style.display = 'none';--}}
{{--                }--}}
{{--            };--}}
{{--        });--}}

{{--        window.onscroll = function () {--}}
{{--            const scrollToTopButton = document.getElementById("scrollToTop");--}}
{{--            if (window.scrollY > 200) {--}}
{{--                scrollToTopButton.style.display = "block";--}}
{{--            } else {--}}
{{--                scrollToTopButton.style.display = "none";--}}
{{--            }--}}
{{--        };--}}

{{--        document.getElementById("scrollToTop").onclick = function () {--}}
{{--            window.scrollTo({ top: 0, behavior: "smooth" });--}}
{{--        };--}}

{{--    </script>--}}

{{--    @include('layouts.footer-user')--}}
{{--@endsection--}}
