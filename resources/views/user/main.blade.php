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

                <div class="slider">
                    <div class="slider-wrapper">
                        <div class="slide"><img src="{{ asset('images/slider-1.jpg') }}" alt="Photo 1"></div>
                        <div class="slide"><img src="{{ asset('images/slider-2.jpg') }}" alt="Photo 2"></div>
                        <div class="slide"><img src="{{ asset('images/slider-3.jpg') }}" alt="Photo 3"></div>
                        <div class="slide"><img src="{{ asset('images/slider-4.jpg') }}" alt="Photo 4"></div>
                        <div class="slide"><img src="{{ asset('images/slider-5.jpg') }}" alt="Photo 5"></div>
                    </div>
                    <button class="prev" onclick="moveSlide(-1)">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="next" onclick="moveSlide(1)">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <div class="dots">
                        <span class="dot" onclick="currentSlide(1)"></span>
                        <span class="dot" onclick="currentSlide(2)"></span>
                        <span class="dot" onclick="currentSlide(3)"></span>
                        <span class="dot" onclick="currentSlide(4)"></span>
                        <span class="dot" onclick="currentSlide(5)"></span>
                    </div>
                </div>
            </div>

            <b class="fishing-shop-container">
                <span class="fishing-shop-container1">
                <span>Магазин «FISHING SHOP» – </span>
                <span class="fishing-shop"> Інноваційні та технологічні риболовні принади за найкращою ціною, які розроблені спеціально для водойм України !!!</span>
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



        </div>
    </div>

    <script>
        let slideIndex = 1;
        showSlides(slideIndex);

        function moveSlide(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            const slides = document.getElementsByClassName("slide");
            const dots = document.getElementsByClassName("dot");

            if (n > slides.length) {
                slideIndex = 1;
            }
            if (n < 1) {
                slideIndex = slides.length;
            }

            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }

            for (let i = 0; i < dots.length; i++) {
                dots[i].classList.remove("active-slide");
            }

            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].classList.add("active-slide");
        }

        setInterval(function() {
            moveSlide(1);
        }, 5000);


    </script>

    @include('layouts.footer-user')

@endsection
