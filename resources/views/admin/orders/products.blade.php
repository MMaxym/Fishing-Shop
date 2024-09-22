@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1400px;">
        <h1>Товари для замовлення №{{ $order->id }}</h1>
        <table class="table table-bordered" style="background-color: #ffffff;">
            <thead>
            <tr>
                <th>Артикул</th>
                <th>Назва</th>
                <th>Категорія</th>
                <th>Опис</th>
                <th>Розмір</th>
                <th>Інше</th>
                <th>Кількість</th>
                <th>Ціна</th>
                <th>Знижка</th>
                <th>Зображення</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $productInOrder)
                <tr>
                    <td>{{ $productInOrder->product->article }}</td>
                    <td>{{ $productInOrder->product->name }}</td>
                    <td>{{ $productInOrder->product->category->name }}</td>
                    <td>{{ $productInOrder->product->description }}</td>
                    <td>{{ $productInOrder->size }}</td>
                    <td>{{ $productInOrder->product->other }}</td>
                    <td>{{ $productInOrder->quantity }}</td>
                    <td>{{ $productInOrder->price }} грн</td>
                    <td>{{ $productInOrder->product->discount ? $productInOrder->product->discount->percentage . '%' : 'Немає' }}</td>
                    <td style="width: 100px;">
                        @if($productInOrder->product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $productInOrder->product->images[0]->image_url) }}" alt="{{ $productInOrder->product->name }}" style="width: 100px; height: auto;">
                        @else
                            <span>Немає зображення</span>
                        @endif
                    </td>


                    {{--     // ДЛЯ ВИВЕДЕННЯ ВСІХ ІСНУЮЧИХ КАРТИНОК--}}
                    {{--                    <td>--}}
{{--                        @if($productInOrder->product->images->isNotEmpty())--}}
{{--                            @foreach($productInOrder->product->images as $image)--}}
{{--                                <img src="{{ asset('storage/' . $image->image_url) }}" alt="{{ $productInOrder->product->name }}" style="width: 50px; height: auto; margin-right: 5px;">--}}
{{--                            @endforeach--}}
{{--                        @else--}}
{{--                            <span>Немає зображень</span>--}}
{{--                        @endif--}}
{{--                    </td>--}}


                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="{{ route('admin.orders.index') }}" class="btn btn-info">
            <i class="fas fa-arrow-left"></i> Назад до замовлень
        </a>
    </div>
@endsection
