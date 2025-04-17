@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/errors/404.css') }}">
    <title>Fishing Store</title>
</head>

@section('content')

    <div class="main-container">
        <a href="{{ route('user.main') }}" class="logo-link">
            <img class="logo-icon" alt="Logo" title="Перейти на головну" src="{{ asset('images/v2/img/logo.svg') }}">
        </a>
        <div class="content">
            <img class="background-img" alt="404 Image" src="{{ asset('images/v2/img/404-img.svg') }}">
            <div class="description">
                <h2 class="description-text">Виникла проблема. Сторінку не знайдено</h2>
                <a class="redirect-to-main" href="{{route('user.main')}}">Повернутися на головну <img class="icon-arrow-right" alt="arrow" src="{{ asset('images/v2/icon/ArrowSmallRight.svg') }}"></a>
            </div>
        </div>
    </div>

@endsection
