<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryPilkerController extends Controller
{
    public function index(){
        return view('user.categoryPilkers');
    }
}
