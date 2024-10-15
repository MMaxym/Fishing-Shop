@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 450px; margin: 0 auto; padding-bottom: 50px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: #d6d6d6;">
                <h2>Редагування статусу замовлення №{{$order->id}}</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="status">Статус</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="В обробці" {{ $order->status == 'В обробці' ? 'selected' : '' }}>В обробці</option>
                            <option value="Завершено" {{ $order->status == 'Завершено' ? 'selected' : '' }}>Завершено</option>
                            <option value="Скасовано" {{ $order->status == 'Скасовано' ? 'selected' : '' }}>Скасовано</option>
                            <option value="Очікує на оплату" {{ $order->status == 'Очікує на оплату' ? 'selected' : '' }}>Очікує на оплату</option>
                            <option value="Доставлено" {{ $order->status == 'Доставлено' ? 'selected' : '' }}>Доставлено</option>
                        </select>
                        @error('status')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-warning">Оновити статус</button>
                        <button type="button" class="btn btn-outline-dark mx-3" id="back-button">
                            <i class="fas fa-arrow-left"></i> Назад</button>
                    </div>

                    <script>
                        document.getElementById('back-button').addEventListener('click', function() {
                            window.location.href = "{{ route('admin.orders.index') }}";
                        });
                    </script>
                </form>
            </div>
        </div>
    </div>
@endsection
