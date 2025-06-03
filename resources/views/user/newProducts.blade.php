@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/newProducts.css') }}">
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
                        <li class="current-product">Новинки</li>
                    </ul>
                </nav>
            </div>
        </section>
        <section class="main-row">
            <div class="products-wrapper">
                <h2 class="row-title" id="main-title">Новинки</h2>
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
                                        <input type="number" id="minPriceInput" value="{{ number_format($minPrice, 0, ',', ' ') ?? 0 }}" oninput="syncMinPriceRange(this.value)" class="price-input">
                                    </div>
                                    <div class="row-price">
                                        <label for="maxPriceInput">Макс:</label>
                                        <input type="number" id="maxPriceInput" value="{{ number_format($maxPrice, 0, ',', ' ') ?? 1000 }}" oninput="syncMaxPriceInput(this.value)" class="price-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="productList">
                        @include('partials.new-products', ['products' => $products])
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

    <script src="{{ asset('js/user/newProducts.js') }}"></script>

@endsection
