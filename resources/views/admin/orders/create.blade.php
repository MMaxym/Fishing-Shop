@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 500px; margin: 0 auto; padding-bottom: 50px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: #d6d6d6;">
                <h2>Додавання нового замовлення</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.store') }}" method="POST">
                    @csrf

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
                        <label for="user_id">Користувач</label>
                        <select name="user_id" id="user_id" class="form-control">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->login }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="payment_method_id">Метод оплати</label>
                        <select name="payment_method_id" id="payment_method_id" class="form-control">
                            @foreach ($paymentMethods as $method)
                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                            @endforeach
                        </select>
                        @error('payment_method_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="shipping_method_id">Метод доставки</label>
                        <select name="shipping_method_id" id="shipping_method_id" class="form-control">
                            @foreach ($shippingMethods as $method)
                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                            @endforeach
                        </select>
                        @error('shipping_method_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="discount_id">Знижка</label>
                        <select name="discount_id" id="discount_id" class="form-control">
                            <option value="">Без знижки</option>
                            @foreach ($discounts as $discount)
                                @if ($discount->type === 'На замовлення')
                                <option value="{{ $discount->id }}">{{ $discount->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('discount_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="address">Адреса</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
                        @error('address')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="total_amount">Загальна сума</label>
                        <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control" value="{{ old('total_amount') }}">
                        @error('total_amount')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Статус</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="В обробці" {{ old('status') == 'В обробці' ? 'selected' : '' }}>В обробці</option>
                            <option value="Завершено" {{ old('status') == 'Завершено' ? 'selected' : '' }}>Завершено</option>
                            <option value="Скасовано" {{ old('status') == 'Скасовано' ? 'selected' : '' }}>Скасовано</option>
                            <option value="Очікує на оплату" {{ old('status') == 'Очікує на оплату' ? 'selected' : '' }}>Очікує на оплату</option>
                            <option value="Доставлено" {{ old('status') == 'Доставлено' ? 'selected' : '' }}>Доставлено</option>
                        </select>
                        @error('status')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-warning">Створити замовлення</button>
                        <button type="button" class="btn btn-outline-primary mx-3" id="back-button">
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
