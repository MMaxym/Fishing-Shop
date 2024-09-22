@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 600px; margin: 0 auto; padding-bottom: 50px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: #d6d6d6;">
                <h2>Редагування зображень товару "{{$product->name}}"</h2>
            </div>
            <div class="card-body">
                @foreach($images as $image)
                    <div class="image-container mb-3" style="display: flex; align-items: center;">
                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="Product Image" style="max-width: 350px; margin-right: 15px;">
                        <form action="{{ route('admin.products.images.delete', [$product, $image]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="margin-left: 30px">
                                <i class="fas fa-trash"></i> Видалити
                            </button>
                        </form>
                    </div>
                @endforeach

                <a href="{{ route('admin.products.images.add', $product) }}" class="btn btn-success mt-3">
                    <i class="fas fa-plus"></i> Додати нове зображення
                </a>
                <button type="button" class="btn btn-outline-primary mx-3 mt-3" id="back-button">Назад <-</button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('back-button').addEventListener('click', function() {
            window.location.href = "{{ route('admin.products.index') }}";
        });
    </script>
@endsection
