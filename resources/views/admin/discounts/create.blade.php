@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 500px; margin: 0 auto; padding: 50px 0;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: #d6d6d6;">
                <h2>Create New Discount</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.discounts.store') }}" method="POST">
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
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="percentage">Percentage</label>
                        <input type="number" class="form-control" id="percentage" name="percentage" value="{{ old('percentage') }}" required>
                        @error('percentage')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="На товар" {{ old('type') == 'На товар' ? 'selected' : '' }}>На товар</option>
                            <option value="На замовлення" {{ old('type') == 'На замовлення' ? 'selected' : '' }}>На замовлення</option>
                        </select>
                        @error('type')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                        @error('start_date')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                        @error('end_date')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-warning">Create</button>
                        <button type="button" class="btn btn-outline-primary mx-3" id="back-button">Back <-</button>
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
