@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 450px; margin: 0 auto; padding: 50px 0;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: #d6d6d6;">
                <h2>Створення Запитання/відовіді</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.questions.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="question">Запитання</label>
                        <input type="text" name="question" class="form-control" required>
                        @error('question')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="answer">Відповідь</label>
                        <textarea name="answer" id="answer" class="form-control" rows="5" style="resize: vertical;" required></textarea>
                        @error('answer')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success">Створити запис</button>
                        <button type="button" class="btn btn-outline-dark mx-3" id="back-button">
                            <i class="fas fa-arrow-left"></i> Назад</button>
                    </div>

                    <script>
                        document.getElementById('back-button').addEventListener('click', function() {
                            window.location.href = "{{ route('admin.questions.index') }}";
                        });
                    </script>
                </form>
            </div>
        </div>
    </div>
@endsection
