@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/about.css') }}">
    <title>Fishing Store - Про нас</title>
</head>

@section('content')

    <div class="container">
        @include('layouts.header-user')

        <section class="about-hero" style="background-image: url('{{ asset('images/about-1.jpg') }}');">
            <div class="hero-content">
                <h1 class="about-title">Про нас</h1>
                <p class="about-subtitle">Ласкаво просимо до «Fishing Shop» — магазину, де починається ваша ідеальна риболовля!</p>
            </div>
        </section>

        <section class="about-details">
            <div class="about-block">
                <h2 class="about-heading">🎣 Інноваційні принади</h2>
                <p class="about-text">
                    Наш магазин пропонує інноваційні та надійні рибальські приманки, розроблені спеціально для водойм України.
                </p>
            </div>
            <div class="about-block">
                <h2 class="about-heading">📦 Широкий асортимент</h2>
                <p class="about-text">
                    В «Fishing Shop» ви знайдете широкий вибір сучасних приладь: від силіконових приманок до балансирів і тейл-спінерів.
                </p>
            </div>
            <div class="about-block">
                <h2 class="about-heading">💬 Професійна підтримка</h2>
                <p class="about-text">
                    Наші експерти завжди готові надати професійну консультацію, допомогти у виборі спорядження та поділитися секретами успішної риболовлі.
                </p>
            </div>
            <div class="about-block">
                <h2 class="about-heading">💸 Знижки та акції</h2>
                <p class="about-text">
                    Ми регулярно проводимо акції та пропонуємо знижки для постійних клієнтів.
                </p>
            </div>
            <div class="about-block">
                <h2 class="about-heading">🤝 Надійний партнер</h2>
                <p class="about-text">
                    «Fishing Shop» — це не просто магазин, це спільнота однодумців, закоханих у риболовлю.
                </p>
            </div>
        </section>

        <div id="scrollToTop" class="scroll-to-top">
            <i class="fas fa-arrow-up"></i>
        </div>

    </div>
    @include('layouts.footer-user')

    <script src="{{ asset('js/user/about.js') }}"></script>

@endsection
