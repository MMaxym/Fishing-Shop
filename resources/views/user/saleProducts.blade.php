@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/user/saleProducts.css') }}">
</head>

@section('content')

    <div class="container" style="max-width: 1600px;">
        @include('layouts.header-user')
        <div style="margin-top: 150px; margin-bottom: 100px; text-align: center;">
            <h2 style="margin-bottom: 50px;">АКЦІЙНІ ТОВАРИ</h2>


        </div>
    </div>
    @include('layouts.footer-user')
@endsection
