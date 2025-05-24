<div class="products-section">
        <div class="cart-products-grid">
            <div class="products-cards">
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

    <div class="pagination-section">
        @if($totalItems == 0)
            <div class="position-info">
                <div class="no-products-message">
                    <p class="empty-cart-text">За обраними фільтрами товари не знайдено.</p>
                    <button class="empty-cart-btn" onclick="resetFilters()">Скинути фільтрацію
{{--                        <img  class="empty-cart-btn-icon" src="{{ asset('images/v2/icon/ArrowBigRightHomeLink.svg') }}" alt="moreIcon">--}}
                    </button>
                    <img  class="empty-cart-img" src="{{ asset('images/v2/img/not-found-products-img.svg') }}" alt="emptyIcon">
                </div><br>
                Позиції: <span id="itemsShown">{{ $itemsShown }}</span> з {{ $totalItems }}
            </div>
        @else
            <div class="position-info">
                Позиції: <span id="itemsShown">{{ $itemsShown }}</span> з {{ $totalItems }}
            </div>
        @endif

        @if ($products->hasMorePages())
            <button id="loadMore" style="margin-top: 20px;">
                <i class="fas fa-sync" style="margin-right: 8px; font-size: var(--Font-18-size);"></i> Завантажити ще
            </button>
        @endif

        <div class="pagination">
            <ul class="pagination-links">
                {{ $products->links('vendor.pagination.default') }}
            </ul>
        </div>
    </div>
</div>
