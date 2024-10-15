@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 450px; margin: 0 auto; padding-bottom: 50px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: #d6d6d6;">
                <h2>Редагування товару "{{$product->name}}"</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product) }}" method="POST">
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
                        <label for="category_id">Категорія</label>
                        <select name="category_id" id="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="discount_id">Знижка</label>
                        <select name="discount_id" id="discount_id" class="form-control">
                            <option value="">Без знижки</option>
                            @foreach ($discounts as $discount)
                                @if ($discount->type === 'На товар') <!-- Додаємо перевірку типу -->
                                <option value="{{ $discount->id }}" {{ $product->discount_id == $discount->id ? 'selected' : '' }}>
                                    {{ $discount->name }}
                                </option>
                                @endif
                            @endforeach
                        </select>
                        @error('discount_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="article">Артикул</label>
                        <input type="text" name="article" id="article" class="form-control" value="{{ $product->article }}" required>
                        @error('article')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Назва</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Опис</label>
                        <textarea name="description" id="description" class="form-control" required>{{ $product->description }}</textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="size">Розмір</label>
                        <input type="text" name="size" id="size" class="form-control" value="{{ $product->size }}">
                        @error('size')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="other">Інше</label>
                        <input type="text" name="other" id="other" class="form-control" value="{{ $product->other }}">
                        @error('other')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="quantity">Кількість</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $product->quantity }}" required>
                        @error('quantity')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Ціна</label>
                        <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
                        @error('price')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="is_active">Активний</label>
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
                        @error('is_active')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-warning">Зберегти зміни</button>
                        <button type="button" class="btn btn-outline-dark mx-3" id="back-button">
                            <i class="fas fa-arrow-left"></i> Назад</button>
                    </div>

                    <script>
                        document.getElementById('back-button').addEventListener('click', function() {
                            window.location.href = "{{ route('admin.products.index') }}";
                        });
                    </script>
                </form>
            </div>
        </div>
    </div>
@endsection
