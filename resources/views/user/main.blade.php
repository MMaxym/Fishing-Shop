@extends('layouts.app')
<head>
    <link rel="stylesheet" href="{{ asset('css/user/main.css') }}">
</head>

@section('content')
    <div class="container" style="max-width: 1600px;">
        @include('layouts.header-user')
        <div style="margin-top: 150px; margin-bottom: 70px;">
            <div class="row">
                <div class="selectedCategory">
                    <div class="category">
                        <i class="foundation--burst-new" style="margin-left: 5px;"></i>
                        <a href="{{route('user.newProducts')}}" style="color: #00d109; margin-left: 3px;">Новинки</a>
                        <i class="fas fa-chevron-right" style="margin-left: 5px; color: #00d109;"></i>
                    </div>
                    <div class="category">
                        <i class="iconamoon--discount" style="margin-left: 5px;"></i>
                        <a href="{{route('user.saleProducts')}}" style="color: #da0000; margin-left: 7px;">Акційні товари</a>
                        <i class="fas fa-chevron-right" style="margin-left: 5px; color: #da0000;"></i>
                    </div>
                    <div class="category">
                        <i class="clarity--fish-line" style="margin-left: 5px;"></i>
                        <a href="{{route('user.categoryTailSpinners')}}">Тейл-спінери</a>
                        <i class="fas fa-chevron-right" style="margin-left: 5px;"></i>
                    </div>
                    <div class="category">
                        <i class="clarity--fish-line" style="margin-left: 5px;"></i>
                        <a href="{{route('user.categoryBalancers')}}">Балансири</a>
                        <i class="fas fa-chevron-right" style="margin-left: 5px;"></i>
                    </div>
                    <div class="category">
                        <i class="clarity--fish-line" style="margin-left: 5px;"></i>
                        <a href="{{route('user.categoryPilkers')}}">Пількери</a>
                        <i class="fas fa-chevron-right" style="margin-left: 5px;"></i>
                    </div>
                </div>

                <div class="main-slider">
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
                </div>
            </div>

            <b class="fishing-shop-container">
                <span class="fishing-shop-container1">
                <span>Магазин «FISHING SHOP» – </span>
                <span class="fishing-shop"> Інноваційні та технологічні риболовні приманки за найкращою ціною, які розроблені спеціально для водойм України !!!</span>
                </span>
            </b>

            <h2 class="category-head">КАТЕГОРІЇ ТОВАРІВ</h2>
            <div class="row-category" style="margin-left: 150px; margin-right: 150px;">
                <div class="parent">
                    <div class="frame-parent">
                        <div class="rectangle-parent" style="margin-right: 50px;">
                            <a href="{{route('user.categoryTailSpinners')}}" style="text-decoration: none; color: inherit;">
                                <img class="frame-child" alt="" src="{{ asset('images/category-3.png') }}">
                                <div class="wrapper">
                                    <b class="b1">Тейл-спінери</b>
                                </div>
                            </a>
                        </div>
                        <div class="rectangle-parent" style="margin-right: 50px;">
                            <a href="{{route('user.categoryBalancers')}}" style="text-decoration: none; color: inherit;">
                                <img class="frame-child" alt="" src="{{ asset('images/category-2.png') }}">
                                <div class="wrapper">
                                    <b class="b1">Балансири</b>
                                </div>
                            </a>
                        </div>
                        <div class="rectangle-parent">
                            <a href="{{route('user.categoryPilkers')}}" style="text-decoration: none; color: inherit;">
                                <img class="frame-child" alt="" src="{{ asset('images/category-1.png') }}">
                                <div class="wrapper">
                                    <b class="b1">Пількери</b>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="top-head">НАШІ ПЕРЕВАГИ</h2>
            <div class="row" style="margin-left: 150px; margin-right: 150px;">
                <div class="parent-top">
                    <div class="frame-parent-top">
                        <div class="vector-parent">
                            <img class="vector-icon" alt="" src="{{ asset('images/top-1.svg') }}">
                            <b class="b1-top">ГАРАНТІЯ ВАРТОСТІ</b>
                            <div class="div">Ми гарантуємо найнижчу ціну, якщо ви знайдете дешевше - ми робимо знижку.</div>
                        </div>
                        <div class="vector-parent">
                            <img class="group-icon" alt="" src="{{ asset('images/top-2.svg') }}">
                            <b class="b1-top">ЗРУЧНА ДОСТАВКА</b>
                            <div class="div">Ви можете забрати замовлення з магазину, замовити кур'єра або логістичну доставку.</div>
                        </div>
                        <div class="vector-parent">
                            <img class="vector-icon1" alt="" src="{{ asset('images/top-3.svg') }}">
                            <b class="b1-top">БОНУСНА ПРОГРАМА</b>
                            <div class="div">Кожному покупцю вручається накопичувальна дисконтна картка.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-new-products" style="margin-left: 150px; margin-right: 150px;">
                <h2 class="new-head">НОВИНКИ</h2>
                <div class="products-grid-scroll">
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
                </div>
                <div class="row-newProducts" style="margin-top: 20px;">
                    <a href="{{ route('user.newProducts') }}" class="load-more-new-products">
                        Переглянути більше новинок <i class="fas fa-arrow-right" style="margin-left: 5px;"></i>
                    </a>
                </div>

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
                                            <div style="padding: 2px 10px; background-color: #2c73bb; color: white; cursor: pointer;" id="decreaseQuantity">-</div>
                                            <span id="quantity" style="text-align:center;">1</span>
                                            <div style="padding: 2px 10px; background-color: #2c73bb; color: white; cursor: pointer;" id="increaseQuantity">+</div>
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
            </div>

            <div class="row-discount-products" style="margin-left: 150px; margin-right: 150px; margin-top: 100px;">
                <h2 class="new-head">АКЦІЙНІ ТОВАРИ</h2>
                <div class="products-grid-scroll" id="scroll2">
                    <div class="products-grid">
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
                                 data-discounted-price="{{ $product2->discount ? $product2->discountedPrice() : $product2->price }}"
                                 data-actual-price="{{$product2->actual_price}}">

                                @if($product2->isDiscounted)
                                    <div class="sale-icon">
                                        <img src="{{ asset('images/sale-icon.png') }}" alt="Sale">
                                    </div>
                                @endif

                                @if($product2->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $product2->images->first()->image_url) }}" alt="{{ $product2->name }}" style="width: 220px; height: 170px;">
                                @else
                                    <span id="notImage">Немає зображення</span>
                                @endif

                                <h3>{{ $product2->name }} ({{ $product2->size}}) - {{ $product2->article }}</h3>

                                @if($product2->discount)
                                    @if($product2->quantity == 0)
                                        <p style="text-decoration: line-through; font-size: 14px;">
                                            {{ number_format($product2->price, 2) }} грн
                                        </p>
                                        <p style="color: red;">
                                            {{ number_format($product2->discountedPrice(), 2) }} грн
                                        </p>
                                        <p style="color: red; font-weight: normal; font-size: 14px;">*Немає в наявності</p>
                                    @elseif($product2->quantity < 50)
                                        <p style="text-decoration: line-through; font-size: 14px;">
                                            {{ number_format($product2->price, 2) }} грн
                                        </p>
                                        <p style="color: red;">
                                            {{ number_format($product2->discountedPrice(), 2) }} грн
                                        </p>
                                        <p style="color: #ff8800; font-weight: normal; font-size: 14px;">*Товар закінчується</p>
                                    @else
                                        <p style="text-decoration: line-through; font-size: 14px; padding-top: 14px;">
                                            {{ number_format($product2->price, 2) }} грн
                                        </p>
                                        <p style="color: red; padding-bottom: 14px;">
                                            {{ number_format($product2->discountedPrice(), 2) }} грн
                                        </p>
                                    @endif
                                @else
                                    @if($product2->quantity == 0)
                                        <p style="padding-top: 15px; padding-bottom: 5px;">{{ number_format($product2->price, 2) }} грн</p>
                                        <p style="color: red; font-weight: normal; font-size: 14px; padding-bottom: 7px;">*Немає в наявності</p>
                                    @elseif($product2->quantity < 50)
                                        <p style="padding-top: 15px; padding-bottom: 5px;">{{ number_format($product2->price, 2) }} грн</p>
                                        <p style="color: #ff8800; font-weight: normal; font-size: 14px; padding-bottom: 7px;">*Товар закінчується</p>
                                    @else
                                        <p style="padding-top: 26px; padding-bottom: 27px;">{{ number_format($product2->price, 2) }} грн</p>
                                    @endif
                                @endif
                                <button class="open-modal">
                                    <i class="fas fa-shopping-cart"></i> Купити
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row-newProducts" style="margin-bottom: 150px; margin-top: 20px;">
                    <a href="{{ route('user.saleProducts') }}" class="load-more-new-products">
                        Переглянути більше акційних товарів <i class="fas fa-arrow-right" style="margin-left: 5px;"></i>
                    </a>
                </div>
            </div>
            <div id="scrollToTop" class="scroll-to-top">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
    </div>

    <script>
        let mainSlideIndex = 1;
        showMainSlides(mainSlideIndex);

        function moveMainSlide(n) {
            showMainSlides(mainSlideIndex += n);
        }

        function currentMainSlide(n) {
            showMainSlides(mainSlideIndex = n);
        }

        function showMainSlides(n) {
            const slides = document.getElementsByClassName("main-slide");
            const dots = document.getElementsByClassName("main-dot");

            if (n > slides.length) {
                mainSlideIndex = 1;
            }
            if (n < 1) {
                mainSlideIndex = slides.length;
            }

            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }

            for (let i = 0; i < dots.length; i++) {
                dots[i].classList.remove("active-main-slide");
            }

            slides[mainSlideIndex - 1].style.display = "block";
            dots[mainSlideIndex - 1].classList.add("active-main-slide");
        }

        setInterval(function() {
            moveMainSlide(1);
        }, 5000);

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


        const scrollContainer = document.querySelector('.products-grid-scroll');
        const scrollSpeed = 2;
        const scrollInterval = 50;
        const delayBetweenScrolls = 2000;

        function startAutoScroll() {
            let scrollAmount = 0;
            const maxScrollLeft = scrollContainer.scrollWidth - scrollContainer.clientWidth;

            const autoScroll = setInterval(() => {
                if (scrollContainer.scrollLeft >= maxScrollLeft) {
                    scrollContainer.scrollLeft = 0;
                    clearInterval(autoScroll);
                    setTimeout(startAutoScroll, delayBetweenScrolls);
                } else {
                    scrollContainer.scrollLeft += scrollSpeed;
                    scrollAmount += scrollSpeed;
                }
            }, scrollInterval);
        }
        setTimeout(startAutoScroll, delayBetweenScrolls);


        // const scrollContainer2 = document.getElementById('scroll2');
        // const scrollSpeed2 = 2;
        // const scrollInterval2 = 50;
        // const delayBetweenScrolls2 = 2000;
        //
        // function startAutoScroll2() {
        //     let scrollAmount2 = 0;
        //     const maxScrollLeft2 = scrollContainer2.scrollWidth - scrollContainer2.clientWidth;
        //
        //     const autoScroll = setInterval(() => {
        //         if (scrollContainer2.scrollLeft >= maxScrollLeft2) {
        //             scrollContainer2.scrollLeft = 0;
        //             clearInterval(autoScroll);
        //             setTimeout(startAutoScroll2, delayBetweenScrolls2);
        //         } else {
        //             scrollContainer2.scrollLeft += scrollSpeed2;
        //             scrollAmount2 += scrollSpeed2;
        //         }
        //     }, scrollInterval2);
        // }
        // setTimeout(startAutoScroll2, delayBetweenScrolls2);

    </script>
    @include('layouts.footer-user')
@endsection
