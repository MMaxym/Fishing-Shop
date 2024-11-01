<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class SearchProductController extends Controller
{
    public function index()
    {
        return view('user.searchProduct');
    }
}
