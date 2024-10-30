<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class ShoppingCartController extends Controller
{
    public function index(){
        return view('user.shoppingCart');
    }
}
