@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-success">Дякуємо! Оплату успішно здійснено.</h2>
        <p>Ми отримали ваше замовлення. Найближчим часом з вами зв'яжеться наш менеджер.</p>
        <a href="{{ route('user.main') }}" class="btn btn-primary mt-3">Повернутись на головну</a>
    </div>
@endsection
