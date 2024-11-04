@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/searchProduct.css') }}">
</head>

@section('content')
    @include('layouts.header-user')
    <div class="container" style="margin-top: 110px; margin-bottom: 150px;">
        <p class="navigate">
            <a href="{{ route('user.main') }}" class="breadcrumb-link">
                <i class="fa fa-home"></i> Головна
            </a>
            > Результати пошуку
        </p>
        <h2 class="page-title">РЕЗУЛЬТАТИ ПОШУКУ ДЛЯ "<span style="color: #2c73bb; text-transform: none;">{{ $query }}</span>"</h2>

    @if(isset($message))
            <div class="no-products-message">
                {{ $message }}
            </div>
        @elseif(isset($products) && $products->isNotEmpty())
                <div class="products-grid">
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
                             data-discounted-price="{{ $product->discount ? $product->discountedPrice() : $product->price }}"
                             data-actual-price="{{$product->actual_price}}">

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
                                        {{ number_format($product->discountedPrice(), 2) }} грн
                                    </p>
                                    <p style="color: red; font-weight: normal; font-size: 14px;">*Немає в наявності</p>
                                @elseif($product->quantity < 50)
                                    <p style="text-decoration: line-through; font-size: 14px;">
                                        {{ number_format($product->price, 2) }} грн
                                    </p>
                                    <p style="color: red;">
                                        {{ number_format($product->discountedPrice(), 2) }} грн
                                    </p>
                                    <p style="color: #ff8800; font-weight: normal; font-size: 14px;">*Товар закінчується</p>
                                @else
                                    <p style="text-decoration: line-through; font-size: 14px; padding-top: 14px;">
                                        {{ number_format($product->price, 2) }} грн
                                    </p>
                                    <p style="color: red; padding-bottom: 14px;">
                                        {{ number_format($product->discountedPrice(), 2) }} грн
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
                            <button class="open-modal">
                                <i class="fas fa-shopping-cart"></i> Купити
                            </button>
                        </div>
                    @endforeach
                </div>
        @else
            <p>Товарів не знайдено.</p>
        @endif

        <div id="productModal" class="modal">
            <div class="modal-content">
                <div class="panel">
                    <p id="modalProductQuantity" style="color: red; font-size: 18px; margin: 0"></p>
                    <span class="close">&times;</span>
                </div>
                <div class="content">
                    <div class="modal-left">
                        <button id="prevButton" class="slider-button" style="background-color: transparent; color: #04396e;">
                            <i class="fas fa-chevron-left" style="font-size:25px; margin: 0;"></i>
                        </button>
                        <div id="productSlider" class="slider">
                            <div class="slides">
                                <img id="modalImage" src="" alt="Product Image" style="width: 100%;">
                            </div>
                            <div class="dots-container"></div>
                        </div>
                        <button id="nextButton" class="slider-button" style="background-color: transparent; color: #04396e;">
                            <i class="fas fa-chevron-right" style="font-size:25px; margin: 0;"></i>
                        </button>
                    </div>
                    <div class="modal-right">
                        <div class="first">
                            <h3 id="modalProductName" style="color: #04396e;"></h3>
                            <h6 id="modalProductArticle" style="color: #989898;"></h6>
                            <p id="modalProductDescription" style="color: #2c73bb;"></p>
                            <div>
                                <p style="font-size: 20px; color: #04396e;">Вага:</p>
                                <p id="modalProductSize" style="font-size: 20px; color: #2c73bb;"></p>
                            </div>
                            <p style="font-size: 20px; color: #04396e; margin-top: 15px;" id="modalProductPrice"></p>
                            <p style="font-size: 25px; color: red; font-weight: bold;" id="modalProductDiscountedPrice"></p>
                        </div>
                        <div class="two">
                            <div class="price">
                            </div>
                            <div class="two-but">
                                <div class="quantity-container" style="margin-bottom: 15px;">
                                    <div style="padding: 2px 12px; background-color: #2c73bb; color: white; cursor: pointer;" id="decreaseQuantity">-</div>
                                    <span id="quantity">1</span>
                                    <div style="padding: 2px 12px; background-color: #2c73bb; color: white; cursor: pointer;" id="increaseQuantity">+</div>
                                </div>
                                <button id="addToCart" style="padding: 7px 15px;">
                                    <i class="fas fa-plus-circle"></i> Додати в кошик
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="scrollToTop" class="scroll-to-top">
            <i class="fas fa-arrow-up"></i>
        </div>
    </div>
    @include('layouts.footer-user')

    <script>
        window.onscroll = function () {
            const scrollToTopButton = document.getElementById("scrollToTop");
            if (window.scrollY > 200) {
                scrollToTopButton.style.display = "block";
            } else {
                scrollToTopButton.style.display = "none";
            }
        };

        document.getElementById("scrollToTop").onclick = function () {
            window.scrollTo({ top: 0, behavior: "smooth" });
        };


        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('productModal');
            const closeModal = document.getElementsByClassName('close')[0];
            const buyButtons = document.querySelectorAll('.product-card button.open-modal');

            buyButtons.forEach(button => {
                const productCard = button.closest('.product-card');

                button.addEventListener('click', function(event) {
                    event.stopPropagation();
                    openModal(productCard);
                });

                productCard.addEventListener('click', function() {
                    openModal(productCard);
                });
            });

            function openModal(productCard) {
                const productId = productCard.getAttribute('data-id');
                const productName = productCard.getAttribute('data-name');
                const productDescription = productCard.getAttribute('data-description');
                const productSize = productCard.getAttribute('data-size');
                const productArticle = productCard.getAttribute('data-article');
                const productPrice = parseFloat(productCard.getAttribute('data-price'));
                const discountedPrice = parseFloat(productCard.getAttribute('data-discounted-price'));
                const actualPrice = parseFloat(productCard.getAttribute('data-actual-price'));
                let productQuantity = parseInt(productCard.getAttribute('data-quantity'));

                const images = productCard.getAttribute('data-image').split(',').map(img => img.trim());

                document.getElementById('modalProductName').innerText = productName;
                document.getElementById('modalProductDescription').innerText = productDescription;
                document.getElementById('modalProductSize').innerText = productSize + " г";
                document.getElementById('modalProductPrice').innerText = productPrice + " грн";
                document.getElementById('modalProductDiscountedPrice').innerText = discountedPrice + " грн";
                document.getElementById('modalProductArticle').innerText = "Артикул: " + productArticle;
                document.getElementById('modalProductQuantity').innerText = productQuantity;

                const priceElement = document.getElementById('modalProductPrice');
                const discountedPriceElement = document.getElementById('modalProductDiscountedPrice');

                if (productPrice !== discountedPrice) {
                    priceElement.innerText = productPrice + " грн";
                    priceElement.style.fontSize = '20px';
                    priceElement.style.textDecoration = 'line-through';
                    priceElement.style.color = '#04396e';
                    priceElement.style.marginTop = '15px';

                    discountedPriceElement.innerText = discountedPrice + " грн";
                    discountedPriceElement.style.fontSize = '25px';
                    discountedPriceElement.style.color = 'red';
                    discountedPriceElement.style.fontWeight = 'bold';
                } else {
                    priceElement.innerText = productPrice + " грн";
                    priceElement.style.fontSize = '25px';
                    priceElement.style.color = '#04396e';
                    priceElement.style.marginTop = '15px';
                    priceElement.style.textDecoration = 'none';
                    discountedPriceElement.innerText = '';
                }

                if (productQuantity === 0) {
                    document.getElementById('modalProductQuantity').innerText = '*Немає в наявності';
                    document.getElementById('modalProductQuantity').style.color = 'red';
                } else if (productQuantity < 50) {
                    document.getElementById('modalProductQuantity').innerText = '*Товар закінчується';
                    document.getElementById('modalProductQuantity').style.color = '#ff8800';
                } else {
                    document.getElementById('modalProductQuantity').innerText = '';
                    document.getElementById('modalProductQuantity').style.color = '';
                }

                let currentIndex = 0;
                let quantity = 1;

                function updateImage() {
                    document.getElementById('modalImage').src = images[currentIndex];
                    updateDots();
                }

                const dotsContainer = document.querySelector('.dots-container');
                dotsContainer.innerHTML = '';
                images.forEach((_, index) => {
                    const dot = document.createElement('span');
                    dot.classList.add('dot');
                    dot.addEventListener('click', function() {
                        currentIndex = index;
                        updateImage();
                    });
                    dotsContainer.appendChild(dot);
                });

                function updateDots() {
                    const dots = document.querySelectorAll('.dot');
                    dots.forEach((dot, index) => {
                        if (index === currentIndex) {
                            dot.classList.add('active');
                        } else {
                            dot.classList.remove('active');
                        }
                    });
                }

                document.getElementById('prevButton').onclick = function() {
                    currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1;
                    updateImage();
                };

                document.getElementById('nextButton').onclick = function() {
                    currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0;
                    updateImage();
                };

                updateImage();

                document.getElementById('quantity').innerText = quantity;

                document.getElementById('decreaseQuantity').onclick = function() {
                    if (quantity > 1) {
                        quantity--;
                        document.getElementById('quantity').innerText = quantity;
                    }
                };

                document.getElementById('increaseQuantity').onclick = function() {
                    if (quantity < productQuantity) {
                        quantity++;
                        document.getElementById('quantity').innerText = quantity;
                    } else {
                        alert('Ви не можете додати більше товарів, ніж є в наявності.');
                    }
                };

                const addToCartButton = document.getElementById('addToCart');

                addToCartButton.onclick = function() {

                    const userId = '{{ auth()->user() ? auth()->user()->id : "None" }}';

                    if (userId === "None") {
                        alert(`Ви не увійшли в акаунт. \nДля подальших дій авторизуйтесь на сайті.`);
                        return;
                    }

                    if (productQuantity === 0) {
                        alert(`На жаль, даного товару немає в наявності. \nВибачте за незручності.`);
                    }
                    else {
                        let cart = JSON.parse(localStorage.getItem(`cart_${userId}`)) || [];

                        const product = {
                            id: productId,
                            name: productName,
                            description: productDescription,
                            size: productSize,
                            article: productArticle,
                            price: productPrice,
                            actualPrice: actualPrice,
                            quantity: quantity,
                            quantityDB: productQuantity,
                            images: images,
                            dateAdded: new Date().getTime()
                        };

                        const existingProduct = cart.find(item => item.article === product.article && item.size === product.size);

                        if (existingProduct) {
                            existingProduct.quantity += quantity;
                            alert(`Товар ${productName} вже є у вашому кошику. \nТому кількість даного товару збільшено на ${quantity}. \nТепер у кошику ${existingProduct.quantity}.`);
                        } else {
                            cart.push(product);
                            alert(`Товар ${productName} додано в кошик з кількістю ${quantity}`);
                        }

                        localStorage.setItem(`cart_${userId}`, JSON.stringify(cart));

                        modal.style.display = 'none';
                    }
                };

                modal.style.display = 'block';
            }

            closeModal.onclick = function() {
                modal.style.display = 'none';
            };

            window.onclick = function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            };
        });
    </script>
@endsection
