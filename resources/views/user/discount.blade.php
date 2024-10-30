@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/discount.css') }}">
</head>

@section('content')

    <div class="container" style="max-width: 1600px;">
        @include('layouts.header-user')
        <div style="margin-top: 150px; margin-bottom: 70px; text-align: center;">
            <h2>Знижки на товари</h2>
            <div class="discount-section">
                @forelse ($productDiscounts as $discount)
                    <div class="discount-card">
                        <h3>{{ $discount->name }}</h3>
                        <p>Знижка: {{ $discount->percentage }}%</p>
                        <p>Період: з {{ $discount->start_date->format('d.m.Y') }} до {{ $discount->end_date->format('d.m.Y') }}</p>
                    </div>
                @empty
                    <p>Наразі немає активних знижок на товари.</p>
                @endforelse
            </div>

            <h2 style="margin-top: 70px;">Знижки на замовлення</h2>
            <div class="discount-section" style="margin-bottom: 100px;">
                @forelse ($orderDiscounts as $discount)
                    <div class="discount-card">
                        <h3>{{ $discount->name }}</h3>
                        <p>Знижка: {{ $discount->percentage }}%</p>
                        <p>Період: з {{ $discount->start_date->format('d.m.Y') }} до {{ $discount->end_date->format('d.m.Y') }}</p>
                    </div>
                @empty
                    <p>Наразі немає активних знижок на замовлення.</p>
                @endforelse
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
    </script>
@endsection
