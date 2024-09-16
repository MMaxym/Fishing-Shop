<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function index()
    {
        $data = ['name' => 'Maksym', 'role' => 'Student'];
        return view('welcome', $data);
    }

    public function about()
    {
        $data = [
            'name' => 'Maksym',
            'role' => 'Student',
             'description' => 'I study at Khmelnytskyi Polytechnic College'];
        return view('about', $data);
    }

    public function contact()
    {
        $data = ['email' => 'makspufi@gmail.com', 'phone' => '+380988678545'];
        return view('contact', $data);
    }

    public function hobbies()
    {
        $hobbies = ['Driving', 'Coding', 'Traveling', 'Fishing'];
        return view('hobbies', compact('hobbies'));
    }

    public function main()
    {
        return view('main');
    }


}
