@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/productDetails.css') }}">
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
                        <li class="breadcrumb-item">
                            @php
                                $categoryName = $product->category->name ?? '';
                            @endphp

                            @if ($categoryName === 'Пількери')
                                <a href="{{ route('user.categoryPilkers') }}">{{ $categoryName }}</a>
                            @elseif ($categoryName === 'Балансири')
                                <a href="{{ route('user.categoryBalancers') }}">{{ $categoryName }}</a>
                            @elseif ($categoryName === 'Тейл-спінери')
                                <a href="{{ route('user.categoryTailSpinners') }}">{{ $categoryName }}</a>
                            @else
                                <a href="{{ route('user.main') }}">{{ $categoryName }} </a>
                            @endif
                            <span class="breadcrumb-separator">
                                <img src="{{ asset('images/v2/icon/ArrowSmallRightNav.svg') }}" alt="Arrow Icon">
                            </span>
                        </li>
                        <li class="current-product"> {{ $product->name }} (арт. {{ $product->article }})</li>
                    </ul>
                </nav>

                <div class="product-info">
                    <div class="product-image-section">
                        <div class="slider-container">
                            <div class="slider-wrapper">
                                @foreach($product->images as $image)
                                    <img src="{{ asset('storage/' . $image->image_url) }}" alt="{{ $product->name }}" class="slider-image">
                                @endforeach
                            </div>
                            <button class="slider-btn prev-btn">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="slider-btn next-btn">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <div class="slider-dots">
                                @if($product->images->isNotEmpty())
                                    @foreach($product->images as $index => $image)
                                        <span class="dot" data-index="{{ $index }}"></span>
                                    @endforeach
                                @else
                                    <span id="notImageProduct">Немає зображення</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="product-detail-info">
                        <h2 class="product-title">{{ $product->name }}
                            <span>
                                @if($product->isNew)
                                    <img  class="product-card-badge" src="{{ asset('images/v2/icon/NewGreen.svg') }}" alt="SaleIcon">
                                @elseif($product->discount)
                                    <img  class="product-card-badge" src="{{ asset('images/v2/icon/SaleOrange.svg') }}" alt="SaleIcon">
                                @endif
                            </span>
                        </h2>
                        <p class="product-article">Артикул товару: {{ $product->article }}</p>
                        <div class="product-status
                                    @if($product->quantity == 0)
                                        out-stock
                                    @elseif($product->quantity < 50)
                                        low-stock
                                    @else
                                        in-stock
                                    @endif
                                ">
                            @if($product->quantity == 0)
                                Немає в наявності <img src="{{ asset('images/v2/icon/CanselFilledStatus.svg') }}" alt="нема" class="status-icon">
                            @elseif($product->quantity < 50)
                                Товар закінчується <img src="{{ asset('images/v2/icon/SaleFilledStatus.svg') }}" alt="мало" class="status-icon">
                            @else
                                Є в наявності <img src="{{ asset('images/v2/icon/DoneFilledStatus.svg') }}" alt="є" class="status-icon">
                            @endif
                        </div>
                        <p class="product-size">Вага: {{ $product->size }} г.</p>
                        <p class="product-description"> {{ $product->description }} </p>
                        @if ($product->discount && $product->discount->end_date >= now())
                            <div class="product-prices">
                                <span class="old-price">{{ number_format($product->price, 0, ',', ' ') }} грн</span>
                                <span class="new-price">{{ number_format($product->actual_price, 0, ',', ' ') }} грн</span>
                                <span class="discount-percentage"> {{ $product->discount->percentage }}% знижка</span>
                            </div>
                        @else
                            <div class="product-prices">
                                <span class="product-price">{{ number_format($product->actual_price, 0, ',', ' ') }} грн</span>
                            </div>
                        @endif

                        <div class="product-buttons">
                            <div class="quantity-control">
                                <button class="qty-btn" onclick="decreaseQty()">
                                    <img class="qty-btn-icon" src="{{ asset('images/v2/icon/ZnakMinus.svg') }}" alt="Home Icon">
                                </button>
                                <span id="qty-value">1</span>
                                <button class="qty-btn" onclick="increaseQty()">
                                    <img class="qty-btn-icon" src="{{ asset('images/v2/icon/ZnakPlus.svg') }}" alt="Home Icon">
                                </button>
                            </div>
                            <button
                                class="add-to-cart-btn"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-article="{{ $product->article }}"
                                data-size="{{ $product->size }}"
                                data-price="{{ $product->price }}"
                                data-actual-price="{{ $product->actual_price }}"
                                data-discount-percentage="{{ $product->discount->percentage ?? ''}}"
                                data-discount-end-date="{{ $product->discount->end_date ?? ''}}"
                                data-image="{{ asset('storage/' . ($product->images->first()->image_url ?? '')) }}"
                            >
                                Додати до кошику
                                <img  class="icon-cart" src="{{ asset('images/v2/icon/BasketOutlineCard.svg') }}" alt="ByIcon">
                            </button>
                            <button class="like-btn" type="button" data-id="{{ $product->id }}">
                                <img src="{{ $product->isLiked ? asset('images/v2/icon/LikeFilledCard.svg') : asset('images/v2/icon/LikeOutlineCard.svg') }}"
                                     alt="Like"
                                     class="like-icon"
                                     data-outline="{{ asset('images/v2/icon/LikeOutlineCard.svg') }}"
                                     data-filled="{{ asset('images/v2/icon/LikeFilledCard.svg') }}">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="decoration-row" id="decoration-row-details-product">
            <img src="{{ asset('images/v2/img/decoration-img.svg') }}" alt="Розділювач" class="decoration-img">
        </div>

        @if($recentlyViewedProducts->isNotEmpty())
            <section class="main-row">
                <div class="recently-products-wrapper">
                    <h2 class="row-title">Нещодавно переглянуті</h2>
                    <div class="recently-products-scroll-container" id="recently-products-scroll-container">
                        <div class="recently-products-cards">
                            @foreach($recentlyViewedProducts as $recentlyViewedProduct)
                                <div class="recently-product-card"
                                     data-id="{{$recentlyViewedProduct->id}}"
                                     data-name="{{ $recentlyViewedProduct->name }}"
                                     data-size="{{ $recentlyViewedProduct->size }}"
                                     data-quantity="{{ $recentlyViewedProduct->quantity }}"
                                     data-description="{{ $recentlyViewedProduct->description }}"
                                     data-image="{{ $recentlyViewedProduct->images->isNotEmpty() ? implode(',', $recentlyViewedProduct->images->map(fn($img) => asset('storage/' . $img->image_url))->toArray()) : '' }}"
                                     data-article="{{ $recentlyViewedProduct->article }}"
                                     data-price="{{ $recentlyViewedProduct->price }}"
                                     data-discounted-price="{{ $recentlyViewedProduct->actual_price }}"
                                     data-actual-price="{{$recentlyViewedProduct->actual_price}}">

                                    {{-- Вміст карточки --}}
                                    @if($recentlyViewedProduct->isNew)
                                        <img  class="recently-product-card-badge" src="{{ asset('images/v2/icon/NewGreen.svg') }}" alt="SaleIcon">
                                    @elseif($recentlyViewedProduct->discount)
                                        <img  class="recently-product-card-badge" src="{{ asset('images/v2/icon/SaleOrange.svg') }}" alt="SaleIcon">
                                    @endif

                                    @if($recentlyViewedProduct->images->isNotEmpty())
                                        <img src="{{ $recentlyViewedProduct->images->first() ? asset('storage/' . $recentlyViewedProduct->images->first()->image_url) : '/images/no-image.png' }}"
                                             alt="{{ $recentlyViewedProduct->name }}"
                                             class="recently-product-card-img"
                                             onclick="window.location.href='{{ route('product.showDetails', ['id' => $recentlyViewedProduct->id]) }}'">
                                    @else
                                        <span id="notImageProduct">Немає зображення</span>
                                    @endif

                                    <div class="recently-product-card-status
                                    @if($recentlyViewedProduct->quantity == 0)
                                        recently-out-stock
                                    @elseif($recentlyViewedProduct->quantity < 50)
                                        recently-low-stock
                                    @else
                                        recently-in-stock
                                    @endif
                                ">
                                        @if($recentlyViewedProduct->quantity == 0)
                                            Немає в наявності <img src="{{ asset('images/v2/icon/CanselFilledStatus.svg') }}" alt="нема" class="recently-status-icon">
                                        @elseif($recentlyViewedProduct->quantity < 50)
                                            Товар закінчується <img src="{{ asset('images/v2/icon/SaleFilledStatus.svg') }}" alt="мало" class="recently-status-icon">
                                        @else
                                            Є в наявності <img src="{{ asset('images/v2/icon/DoneFilledStatus.svg') }}" alt="є" class="recently-status-icon">
                                        @endif
                                    </div>
                                    <div class="recently-product-card-name">{{ $recentlyViewedProduct->name }} (арт. {{$recentlyViewedProduct->article}})</div>

                                    @if ($recentlyViewedProduct->discount && $recentlyViewedProduct->discount->end_date >= now())

                                        <div class="recently-product-card-prices">
                                            <span class="recently-old-price">{{ number_format($recentlyViewedProduct->price, 0, ',', ' ') }} грн</span>
                                            <span class="recently-new-price">{{ number_format($recentlyViewedProduct->actual_price, 0, ',', ' ') }} грн</span>
                                        </div>
                                    @else
                                        <div class="recently-product-card-prices">
                                            <span class="recently-product-price">{{ number_format($recentlyViewedProduct->actual_price, 0, ',', ' ') }} грн</span>
                                        </div>
                                    @endif
                                    <div class="recently-product-card-buttons">
                                        <button class="recently-like-btn" type="button" data-id="{{ $recentlyViewedProduct->id }}">
                                            <img src="{{ $recentlyViewedProduct->isLiked ? asset('images/v2/icon/LikeFilledCard.svg') : asset('images/v2/icon/LikeOutlineCard.svg') }}"
                                                 alt="Like"
                                                 class="recently-like-icon"
                                                 data-outline="{{ asset('images/v2/icon/LikeOutlineCard.svg') }}"
                                                 data-filled="{{ asset('images/v2/icon/LikeFilledCard.svg') }}">
                                        </button>
                                        <button class="recently-buy-btn" type="button" onclick="window.location.href='{{ route('product.showDetails', ['id' => $recentlyViewedProduct->id]) }}'">Купити
                                            <img  class="recently-buy-btn-icon" src="{{ asset('images/v2/icon/BasketOutlineCard.svg') }}" alt="ByIcon">
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </main>

    @include('layouts.footer-user')

    <script src="{{ asset('js/user/productDetails.js') }}"></script>

@endsection
