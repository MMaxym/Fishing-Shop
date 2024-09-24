@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 500px; margin: 0 auto; padding: 50px 0;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: #d6d6d6;">
                <h2>Редагування знижки "{{$discount->name}}"</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.discounts.update', $discount) }}" method="POST">
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
                        <label for="name">Назва</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $discount->name) }}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="percentage">Відсоток</label>
                        <input type="number" name="percentage" class="form-control" value="{{ old('percentage', $discount->percentage) }}" required>
                        @error('percentage')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="type">Тип</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="На товар" {{ old('type') == 'На товар' ? 'selected' : '' }}>На товар</option>
                            <option value="На замовлення" {{ old('type') == 'На замовлення' ? 'selected' : '' }}>На замовлення</option>
                        </select>
                        @error('type')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="start_date">Дата початку</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $discount->start_date->format('Y-m-d')) }}" required>
                        @error('start_date')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="end_date">Дата завершення</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $discount->end_date->format('Y-m-d')) }}" required>
                        @error('end_date')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-warning">Зберегти зміни</button>
                        <button type="button" class="btn btn-outline-primary mx-3" id="back-button">
                            <i class="fas fa-arrow-left"></i> Назад</button>
                    </div>

                    <script>
                        document.getElementById('back-button').addEventListener('click', function() {
                            window.location.href = "{{ route('admin.discounts.index') }}";
                        });
                    </script>
                </form>
            </div>
        </div>
    </div>
@endsection
