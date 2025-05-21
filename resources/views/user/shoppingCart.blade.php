@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/shoppingCart.css') }}">
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
                        <li class="current-product"> Кошик</li>
                    </ul>
                </nav>
            </div>
        </section>

        <section class="main-row">
            <div class="products-wrapper">
                <h2 class="row-title">Кошик</h2>
                <div class="cart-products">
                    <div class="cart-items-container">
                        @php
                            $cart = session('cart', []);
                        @endphp

                        @if(count($cart) > 0)
                            <div class="cart-table-head">
                                <div class="col product-title">Товар</div>
                                <div class="col price-title">Ціна</div>
                                <div class="col quantity-title">К-сть</div>
                                <div class="col total-title">Вартість</div>
                            </div>
                        @endif

                        @forelse ($cart as $item)
                            <div class="cart-item"
                                 data-id="{{ $item['id'] }}"
                                 data-price="{{ $item['price'] }}"
                                 data-actual-price="{{ $item['actualPrice'] }}"
                                 data-quantity="{{ $item['quantity'] }}">

                                <div class="cart-item-image">
                                    <a href="{{ route('product.showDetails', ['id' => $item['id']]) }}">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                    </a>
                                </div>
                                <div class="cart-item-details">
                                    <a href="{{ route('product.showDetails', ['id' => $item['id']]) }}" class="cart-item-link">
                                        <div class="cart-item-name">{{ $item['name'] }}</div>
                                    </a>
                                    <div class="cart-item-article">арт. {{ $item['article'] }}</div>
                                </div>

                                @php
                                    $hasDiscount = $item['discountPercentage'] && $item['discountEndDate'] && \Carbon\Carbon::parse($item['discountEndDate'])->isFuture();
                                @endphp

                                <div class="cart-item-price" data-actual-price="{{ $item['actualPrice'] }}">
                                    @if ($hasDiscount)
                                        <div class="old-price-section">
                                            <span class="old-price">
                                                {{ number_format($item['price'], 0, ' ', ' ') }} грн
                                            </span>
                                            <span class="discount-badge">
                                                - {{ $item['discountPercentage'] }}%
                                            </span>
                                        </div>
                                        <div class="new-price">
                                            {{ number_format($item['actualPrice'], 0, ' ', ' ') }} грн
                                        </div>
                                    @else
                                        <span class="product-price">
                                            {{ number_format($item['actualPrice'], 0, ' ', ' ') }} грн
                                        </span>
                                    @endif
                                </div>

                                <div class="cart-item-quantity" data-id="{{ $item['id'] }}">
                                    <button class="quantity-decrease">
                                        <img class="qty-btn-icon" src="{{ asset('images/v2/icon/ZnakMinus.svg') }}" alt="-">
                                    </button>
                                    <span class="quantity-value">{{ $item['quantity'] }}</span>
                                    <button class="quantity-increase">
                                        <img class="qty-btn-icon" src="{{ asset('images/v2/icon/ZnakPlus.svg') }}" alt="+">
                                    </button>
                                </div>

                                <div class="cart-item-total" >{{ number_format($item['actualPrice'] * $item['quantity'], 0, ' ', ' ') }} грн</div>

                                <button class="cart-item-remove">
                                    <img class="remove-item-icon" src="{{ asset('images/v2/icon/ZnakPlus.svg') }}" alt="+">
                                </button>
                            </div>
                        @empty
                            <div class="empty-cart">
                                <p class="empty-cart-text">Ваш кошик порожній. Ви не додали у кошик жодного товару.</p>
                                <button class="empty-cart-btn" onclick="window.location.href='{{ route('user.main') }}'">Продовжити покупки
                                    <img  class="empty-cart-btn-icon" src="{{ asset('images/v2/icon/ArrowBigRightHomeLink.svg') }}" alt="moreIcon">
                                </button>
                                <img  class="empty-cart-img" src="{{ asset('images/v2/img/not-found-products-img.svg') }}" alt="emptyIcon">
                            </div>
                        @endforelse
                    </div>

                    @if(count($cart) > 0)
                        @php
                            $pr1 = array_sum(array_map(fn($i) => (float)$i['price'] * (int)$i['quantity'], $cart));
                            $pr2 = array_sum(array_map(fn($i) => (float)$i['actualPrice'] * (int)$i['quantity'], $cart));

                            $discount = round($pr1 - $pr2);

                            $pr1Formatted = number_format($pr1, 0, '.', ' ');
                            $pr2Formatted = number_format($pr2, 0, '.', ' ');
                            $discountFormatted = number_format($discount, 0, '.', ' ');
                        @endphp

                        <div class="cart-summary">
                            <h3 class="summary-title">Замовлення</h3>
                            <div class="summary-line"><span>Сума:</span> <span id="summary-total-price">{{ $pr1Formatted }} грн</span></div>
                            <div class="summary-line"><span>Знижка:</span> <span id="summary-discount">- {{ $discountFormatted }} грн</span></div>
                            <div class="summary-line total"><span>ВСЬОГО:</span> <span id="summary-final-price">{{ $pr2Formatted }} грн</span></div>
                            <button class="checkout-button" onclick="window.location.href='{{ route('user.checkoutPage') }}'">Оформити замовлення
                                <img  class="icon-cart" src="{{ asset('images/v2/icon/PayCart.svg') }}" alt="PayIcon">
                            </button>
                        </div>
                    @endif
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
                                     data-discounted-price="{{ $recentlyViewedProduct->discount ? $recentlyViewedProduct->discountedPrice() : $recentlyViewedProduct->price }}"
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
                                             class="recently-product-card-img">
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
{{--    <pre>{{ print_r(session()->all(), true) }}</pre>--}}

    @include('layouts.footer-user')

    <script src="{{ asset('js/user/shoppingCart.js') }}"></script>

@endsection
