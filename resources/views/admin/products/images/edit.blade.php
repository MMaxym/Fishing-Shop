@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Product Images</h1>
        @foreach($images as $image)
            <div class="image-container">
                <img src="{{ asset('storage/' . $image->image_url) }}" alt="Product Image">
                <form action="{{ route('admin.products.images.delete', [$product, $image]) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        @endforeach
        <a href="{{ route('admin.products.images.add', $product) }}" class="btn btn-primary">Add New Image</a>
    </div>
@endsection
