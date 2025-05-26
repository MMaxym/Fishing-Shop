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

                    @if($product->discount)
                        <img  class="product-card-badge" src="{{ asset('images/v2/icon/SaleOrange.svg') }}" alt="SaleIcon">
                    @elseif($product->isNew)
                        <img  class="product-card-badge" src="{{ asset('images/v2/icon/NewGreen.svg') }}" alt="SaleIcon">
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
