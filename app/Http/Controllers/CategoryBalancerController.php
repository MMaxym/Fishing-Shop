<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryBalancerController extends Controller
{
    public function index(){
        return view('user.categoryBalancers');
    }
}
