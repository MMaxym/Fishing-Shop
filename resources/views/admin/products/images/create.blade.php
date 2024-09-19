@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Product Image</h1>
        <form action="{{ route('admin.products.images.store', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Image</button>
        </form>
    </div>
@endsection
