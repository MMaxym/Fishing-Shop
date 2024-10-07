@extends('layouts.app')

@section('content')

        <h1>Головна сторінка для користувача</h1>
        <span class="mr-3" style="font-size: 22px; color: #04396E;">{{ Auth::user()->login }}</span>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-outline-light px-3 py-2" style="border: none; background: transparent;">
                <i class="fas fa-sign-out-alt" style="font-size: 1.3rem; color: #04396E;"></i>
            </button>
        </form>
@endsection
