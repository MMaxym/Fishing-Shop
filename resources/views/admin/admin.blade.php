@extends('layouts.app')

@section('content')
    <div class="container">

        @include('layouts.heder-admin')

        <div class="jumbotron jumbotron-fluid" style="border-radius: 10px; margin-top: 100px; background-color: #cedde6;">
            <div class="container">
                <h2 class="display-4" style="margin-bottom: 40px;">Вас вітає панель адміністратора!</h2>
                <p class="lead">Тут ви можете керувати користувачами, товарами, замовленнями та знижками вашого інтернет-магазину. Щоб почати, виберіть відповідний розділ у навігаційному меню.</p>
                <p>Якщо у вас виникли запитання чи проблеми, зверніться до нашої документації або зверніться до технічної підтримки.</p>
            </div>
        </div>

    </div>
@endsection
