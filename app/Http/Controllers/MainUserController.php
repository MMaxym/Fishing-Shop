<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainUserController extends Controller
{
    public function index(){
        return view('user.main');
    }
}
