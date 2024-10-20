@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/newProducts.css') }}">
</head>

@section('content')

    <div class="container" style="max-width: 1600px;">
        @include('layouts.header-user')
        <div style="margin-top: 120px; margin-bottom: 100px; text-align: center;">
            <p class="navigate">
                <a href="{{ route('user.main') }}" class="breadcrumb-link">
                    <i class="fa fa-home"></i> Головна
                </a>
                >> Новинки
            </p>
            <h2 class="page-title">НОВИНКИ</h2>

            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        @if($product->isNew)
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

    <script>
        let currentPage = {{ $products->currentPage() }};
        let totalItems = {{ $totalItems }};

        function loadMoreProducts() {
            currentPage++;

            fetch(`{{ route('user.newProducts') }}?page=${currentPage}`)
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

    </script>
    @include('layouts.footer-user')
@endsection
