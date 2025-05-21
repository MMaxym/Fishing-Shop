<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FavoriteProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SearchProductController extends Controller
{
    public function index()
    {
        return view('user.searchProduct');
    }
}
