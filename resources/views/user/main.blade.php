@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/main.css') }}">
</head>

@section('content')

    @include('layouts.header-user')

    <main class="main-section">
        <section class="main-row">
            <div class="nav-section">
                <div class="nav-text">
                    <h2 class="nav-title">FISHING STORE</h2>
                    <p class="nav-description">Інноваційні та технологічні риболовні приманки за найкращою ціною.</p>
                </div>
                <nav class="navigate-category">
                    <a href="{{route('user.newProducts')}}" class="navigate-link" id="navigate-link-content-top">
                        <div class="navigate-link-content" id="navigate-link-content-top">
                            <img src="{{ asset('images/v2/icon/NewOutlineLinlk.svg') }}" alt="Новинки" class="navigate-icon">
                            <span class="navigate-text">Новинки</span>
                        </div>
                    </a>
                    <a href="{{route('user.saleProducts')}}" class="navigate-link">
                        <div class="navigate-link-content">
                            <img src="{{ asset('images/v2/icon/SaleOutlineLink.svg') }}" alt="Акційні товари" class="navigate-icon">
                            <span class="navigate-text">Акційні товари</span>
                        </div>
                    </a>
                    <a href="{{route('user.categoryBalancers')}}" class="navigate-link">
                        <div class="navigate-link-content">
                            <img src="{{ asset('images/v2/icon/FishLink.svg') }}" alt="Балансири" class="navigate-icon">
                            <span class="navigate-text">Балансири</span>
                        </div>
                    </a>
                    <a href="{{route('user.categoryTailSpinners')}}" class="navigate-link">
                        <div class="navigate-link-content">
                            <img src="{{ asset('images/v2/icon/FishLink.svg') }}" alt="Тейл-спінери" class="navigate-icon">
                            <span class="navigate-text">Тейл-спінери</span>
                        </div>
                    </a>
                    <a href="{{route('user.categoryPilkers')}}" class="navigate-link" id="navigate-link-content-bottom">
                        <div class="navigate-link-content" id="navigate-link-content-bottom">
                            <img src="{{ asset('images/v2/icon/FishLink.svg') }}" alt="Пількери" class="navigate-icon">
                            <span class="navigate-text">Пількери</span>
                        </div>
                    </a>
                </nav>
            </div>

            <section class="slider-section">
                <div class="main-slider-wrapper">
                    <div class="main-slide"><img src="{{ asset('images/slider-1.jpg') }}" alt="Photo 1"></div>
                    <div class="main-slide"><img src="{{ asset('images/slider-2.jpg') }}" alt="Photo 2"></div>
                    <div class="main-slide"><img src="{{ asset('images/slider-3.jpg') }}" alt="Photo 3"></div>
                    <div class="main-slide"><img src="{{ asset('images/slider-4.jpg') }}" alt="Photo 4"></div>
                    <div class="main-slide"><img src="{{ asset('images/slider-5.jpg') }}" alt="Photo 5"></div>
                </div>
                <button class="main-prev" onclick="moveMainSlide(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="main-next" onclick="moveMainSlide(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
                <div class="main-dots">
                    <span class="main-dot" onclick="currentMainSlide(1)"></span>
                    <span class="main-dot" onclick="currentMainSlide(2)"></span>
                    <span class="main-dot" onclick="currentMainSlide(3)"></span>
                    <span class="main-dot" onclick="currentMainSlide(4)"></span>
                    <span class="main-dot" onclick="currentMainSlide(5)"></span>
                </div>
            </section>
        </section>

        <section class="main-row">
            <div class="advantages-wrapper">
                <h2 class="row-title">Працюємо для вас</h2>
                <div class="advantages">
                    <div class="advantage">
                        <img src="{{ asset('images/v2/img/advantage-img-1.svg') }}" alt="Перевага 1" class="advantage-img">
                        <h3 class="advantage-title">Зручна доставка</h3>
                        <p class="advantage-text">Ми доставляємо замовлення у найкоротші строки по всій Україні.</p>
                    </div>
                    <div class="advantage">
                        <img src="{{ asset('images/v2/img/advantage-img-2.svg') }}" alt="Перевага 2" class="advantage-img">
                        <h3 class="advantage-title">Чудова підтримка</h3>
                        <p class="advantage-text">Наші менеджери завжди на зв’язку з Вами для консультацій у найкоротші строки.</p>
                    </div>
                    <div class="advantage">
                        <img src="{{ asset('images/v2/img/advantage-img-3.svg') }}" alt="Перевага 3" class="advantage-img">
                        <h3 class="advantage-title">Доступна ціна</h3>
                        <p class="advantage-text">Ми гарантуємо найнижчу ціну, якщо ви знайдете дешевше - ми робимо знижку.</p>
                    </div>
                    <div class="advantage">
                        <img src="{{ asset('images/v2/img/advantage-img-4.svg') }}" alt="Перевага 4" class="advantage-img">
                        <h3 class="advantage-title">Дисконтна програма</h3>
                        <p class="advantage-text">Кожному покупцеві вручається накопичувальна дисконтна картка.</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="decoration-row">
            <img src="{{ asset('images/v2/img/decoration-img.svg') }}" alt="Розділювач" class="decoration-img">
        </div>

        <section class="main-row">
            <div class="categories-wrapper">
                <h2 class="row-title">Категорії</h2>
                <div class="categories">
                    <a href="{{route('user.categoryPilkers')}}" class="category-card">
                        <div class="category-top">
                            <div class="category-bg-shape"></div>
                            <img src="{{ asset('images/v2/img/category-pilker.png') }}" alt="Пількери" class="category-img" style="max-height: 100%;">
                        </div>
                        <div class="category-bottom">
                            <h3 class="category-name">Пількери</h3>
                            <div class="category-btn">
                                <img src="{{ asset('images/v2/icon/ArrowBigRightCategory.svg') }}" alt="Детальніше">
                            </div>
                        </div>
                    </a>

                    <a href="{{route('user.categoryTailSpinners')}}" class="category-card">
                        <div class="category-top">
                            <div class="category-bg-shape"></div>
                            <img src="{{ asset('images/v2/img/category-tail-spinner-img.svg') }}" alt="Тейл-спінери" class="category-img" id="category-img-tail-spinner">
                        </div>
                        <div class="category-bottom">
                            <h3 class="category-name">Тейл-спінери</h3>
                            <div class="category-btn">
                                <img src="{{ asset('images/v2/icon/ArrowBigRightCategory.svg') }}" alt="Детальніше">
                            </div>
                        </div>
                    </a>

                    <a href="{{route('user.categoryBalancers')}}" class="category-card">
                        <div class="category-top">
                            <div class="category-bg-shape"></div>
                            <img src="{{ asset('images/v2/img/category-balansir-img.svg') }}" alt="Балансири" class="category-img">
                        </div>
                        <div class="category-bottom">
                            <h3 class="category-name">Балансири</h3>
                            <div class="category-btn">
                                <img src="{{ asset('images/v2/icon/ArrowBigRightCategory.svg') }}" alt="Детальніше">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section class="main-row">
            <div class="products-wrapper">
                <h2 class="row-title">Новинки</h2>
                <div class="products-scroll-container" id="new-products-scroll-container">
                    <div class="products-cards" id="new-products-container" >
                        @foreach($products as $product)
                            <div class="product-card"
                                 data-id="{{$product->id}}"
                                 data-name="{{ $product->name }}"
                                 data-size="{{ $product->size }}"
                                 data-quantity="{{ $product->quantity }}"
                                 data-description="{{ $product->description }}"
                                 data-image="{{ $product->images->isNotEmpty() ? implode(',', $product->images->map(fn($img) => asset('storage/' . $img->image_url))->toArray()) : '' }}"
                                 data-article="{{ $product->article }}"
                                 data-price="{{ $product->price }}"
                                 data-discounted-price="{{ $product->actual_price }}"
                                 data-actual-price="{{$product->actual_price}}">

                                {{-- Вміст карточки --}}
                                @if($product->isNew)
                                    <img  class="product-card-badge" src="{{ asset('images/v2/icon/NewGreen.svg') }}" alt="SaleIcon">
                                @elseif($product->discount)
                                    <img  class="product-card-badge" src="{{ asset('images/v2/icon/SaleOrange.svg') }}" alt="SaleIcon">
                                @endif


                                @if($product->images->isNotEmpty())
                                    <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->image_url) : '/images/no-image.png' }}"
                                         alt="{{ $product->name }}"
                                         class="product-card-img"
                                         onclick="window.location.href='{{ route('product.showDetails', ['id' => $product->id]) }}'">
                                @else
                                    <span id="notImageProduct">Немає зображення</span>
                                @endif

                                <div class="product-card-status
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
                                <div class="product-card-name">{{ $product->name }} (арт. {{$product->article}})</div>

                                @if ($product->discount && $product->discount->end_date >= now())
                                    <div class="product-card-prices">
                                        <span class="old-price">{{ number_format($product->price, 0, ',', ' ') }} грн</span>
                                        <span class="new-price">{{ number_format($product->actual_price, 0, ',', ' ') }} грн</span>
                                    </div>
                                @else
                                    <div class="product-card-prices">
                                        <span class="product-price">{{ number_format($product->actual_price, 0, ',', ' ') }} грн</span>
                                    </div>
                                @endif


                                <div class="product-card-buttons">
                                    <button class="like-btn" type="button" data-id="{{ $product->id }}">
                                        <img src="{{ $product->isLiked ? asset('images/v2/icon/LikeFilledCard.svg') : asset('images/v2/icon/LikeOutlineCard.svg') }}"
                                             alt="Like"
                                             class="like-icon"
                                             data-outline="{{ asset('images/v2/icon/LikeOutlineCard.svg') }}"
                                             data-filled="{{ asset('images/v2/icon/LikeFilledCard.svg') }}">
                                    </button>

                                    <button class="buy-btn" type="button" onclick="window.location.href='{{ route('product.showDetails', ['id' => $product->id]) }}'">Купити
                                        <img  class="buy-btn-icon" src="{{ asset('images/v2/icon/BasketOutlineCard.svg') }}" alt="ByIcon">
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button class="products-link" onclick="window.location.href='{{ route('user.newProducts') }}'">Переглянути більше
                    <img  class="products-link-icon" src="{{ asset('images/v2/icon/ArrowBigRightSaleLink.svg') }}" alt="ByIcon">
                </button>
            </div>
        </section>

        <div class="decoration-row">
            <img src="{{ asset('images/v2/img/decoration-img.svg') }}" alt="Розділювач" class="decoration-img">
        </div>

        <section class="main-row">
            <div class="products-wrapper">
                <h2 class="row-title">Акційні товари</h2>
                <div class="products-scroll-container" id="sail-products-scroll-container">
                    <div class="products-cards">
                        @foreach($products2 as $product2)
                            <div class="product-card"
                                 data-id="{{$product2->id}}"
                                 data-name="{{ $product2->name }}"
                                 data-size="{{ $product2->size }}"
                                 data-quantity="{{ $product2->quantity }}"
                                 data-description="{{ $product2->description }}"
                                 data-image="{{ $product2->images->isNotEmpty() ? implode(',', $product2->images->map(fn($img) => asset('storage/' . $img->image_url))->toArray()) : '' }}"
                                 data-article="{{ $product2->article }}"
                                 data-price="{{ $product2->price }}"
                                 data-discounted-price="{{ $product2->actual_price }}"
                                 data-actual-price="{{$product2->actual_price}}">

                                {{-- Вміст карточки --}}
                                @if($product2->isNew)
                                    <img  class="product-card-badge" src="{{ asset('images/v2/icon/NewGreen.svg') }}" alt="SaleIcon">
                                @elseif($product2->discount)
                                    <img  class="product-card-badge" src="{{ asset('images/v2/icon/SaleOrange.svg') }}" alt="SaleIcon">
                                @endif

                                @if($product2->images->isNotEmpty())
                                    <img src="{{ $product2->images->first() ? asset('storage/' . $product2->images->first()->image_url) : '/images/no-image.png' }}"
                                         alt="{{ $product2->name }}"
                                         class="product-card-img"
                                         onclick="window.location.href='{{ route('product.showDetails', ['id' => $product2->id]) }}'">
                                @else
                                    <span id="notImageProduct">Немає зображення</span>
                                @endif

                                <div class="product-card-status
                                    @if($product2->quantity == 0)
                                        out-stock
                                    @elseif($product2->quantity < 50)
                                        low-stock
                                    @else
                                        in-stock
                                    @endif
                                ">
                                    @if($product2->quantity == 0)
                                        Немає в наявності <img src="{{ asset('images/v2/icon/CanselFilledStatus.svg') }}" alt="нема" class="status-icon">
                                    @elseif($product2->quantity < 50)
                                        Товар закінчується <img src="{{ asset('images/v2/icon/SaleFilledStatus.svg') }}" alt="мало" class="status-icon">
                                    @else
                                        Є в наявності <img src="{{ asset('images/v2/icon/DoneFilledStatus.svg') }}" alt="є" class="status-icon">
                                    @endif
                                </div>
                                <div class="product-card-name">{{ $product2->name }} (арт. {{$product2->article}})</div>

                                @if ($product2->discount && $product2->discount->end_date >= now())

                                <div class="product-card-prices">
                                        <span class="old-price">{{ number_format($product2->price, 0, ',', ' ') }} грн</span>
                                        <span class="new-price">{{ number_format($product2->actual_price, 0, ',', ' ') }} грн</span>
                                    </div>
                                @else
                                    <div class="product-card-prices">
                                        <span class="product-price">{{ number_format($product2->actual_price, 0, ',', ' ') }} грн</span>
                                    </div>
                                @endif


                                <div class="product-card-buttons">
                                    <button class="like-btn" type="button" data-id="{{ $product2->id }}">
                                        <img src="{{ $product2->isLiked ? asset('images/v2/icon/LikeFilledCard.svg') : asset('images/v2/icon/LikeOutlineCard.svg') }}"
                                             alt="Like"
                                             class="like-icon"
                                             data-outline="{{ asset('images/v2/icon/LikeOutlineCard.svg') }}"
                                             data-filled="{{ asset('images/v2/icon/LikeFilledCard.svg') }}">
                                    </button>
                                    <button class="buy-btn" type="button" onclick="window.location.href='{{ route('product.showDetails', ['id' => $product2->id]) }}'">Купити
                                        <img  class="buy-btn-icon" src="{{ asset('images/v2/icon/BasketOutlineCard.svg') }}" alt="ByIcon">
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button class="products-link" onclick="window.location.href='{{ route('user.saleProducts') }}'">Переглянути більше
                    <img  class="products-link-icon" src="{{ asset('images/v2/icon/ArrowBigRightSaleLink.svg') }}" alt="ByIcon">
                </button>
            </div>
        </section>

        <section class="main-row">
            <div class="faqs-wrapper">
                <h2 class="row-title">Найпопулярніші запитанння</h2>
                <div class="faq-list">
                    @foreach($faqs as $index => $faq)
                        <div class="faq-item">
                            <div class="faq-question">
                                <span class="faq-number">{{ $index + 1 }}</span>
                                <span class="faq-question-text">{{ $faq->question }}</span>
                                <button class="toggle-answer" aria-label="Toggle answer">
                                    <img  class="arrow-icon" src="{{ asset('images/v2/icon/ArrowSmallDownFAQ.svg') }}" alt="ArrowIcon">
                                </button>
                            </div>
                            <div class="faq-answer">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    @include('layouts.footer-user')

    <script src="{{ asset('js/user/main.js') }}"></script>

@endsection
