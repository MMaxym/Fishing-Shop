@extends('layouts.app')

@section('content')
    <div class="container">
        <header class="d-flex justify-content-between align-items-center mb-4 py-3 border-bottom">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mr-3" style="width: 50px; height: auto;">
                <h1 class="mb-0">Admin Panel</h1>
            </div>

            <nav>
                <ul class="nav">
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link btn btn-primary mx-3">Users</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.products.index') }}" class="nav-link btn btn-primary mx-3">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary mx-3">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link btn btn-primary mx-3">Discounts</a>
                    </li>

{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('admin.orders.index') }}" class="nav-link btn btn-outline-primary">Orders</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('admin.discounts.index') }}" class="nav-link btn btn-outline-primary">Discounts</a>--}}
{{--                    </li>--}}
                </ul>
            </nav>
        </header>

        <div class="jumbotron jumbotron-fluid bg-light" style="border-radius: 10px;">
            <div class="container">
                <h2 class="display-4" style="margin-bottom: 40px;">Welcome to the admin panel!</h2>
                <p class="lead">Here you can manage users, products, orders and discounts of your online store. Select the appropriate section from the navigation menu to get started.</p>
                <p>If you have any questions or problems, please refer to our documentation or contact technical support.</p>
            </div>
        </div>
    </div>
@endsection
