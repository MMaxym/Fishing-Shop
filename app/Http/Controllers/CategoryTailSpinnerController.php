<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryTailSpinnerController extends Controller
{
    public function index(){
        return view('user.categoryTailSpinners');
    }
}
