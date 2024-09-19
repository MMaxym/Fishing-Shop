@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 500px; margin: 0 auto; padding-bottom: 50px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: #d6d6d6;">
                <h2>Add New Product</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.store') }}" method="POST">
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
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="discount_id">Discount</label>
                        <select name="discount_id" id="discount_id" class="form-control">
                            <option value="">No Discount</option>
                            @foreach ($discounts as $discount)
                                <option value="{{ $discount->id }}">{{ $discount->name }}</option>
                            @endforeach
                        </select>
                        @error('discount_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="article">Article</label>
                        <input type="text" name="article" id="article" class="form-control" value="{{ old('article') }}">
                        @error('article')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="size">Size</label>
                        <input type="text" name="size" id="size" class="form-control" value="{{ old('size') }}">
                        @error('size')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="other">Other</label>
                        <input type="text" name="other" id="other" class="form-control" value="{{ old('other') }}">
                        @error('other')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity') }}">
                        @error('quantity')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price') }}">
                        @error('price')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="is_active">Active</label>
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                        @error('is_active')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-warning">Create Product</button>
                        <button type="button" class="btn btn-outline-primary mx-3" id="back-button">Back <-</button>
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
