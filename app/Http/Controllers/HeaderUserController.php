<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class HeaderUserController extends Controller
{
    public function editProfile(){
        return view('user.editProfile');
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $isLoginChanged = $user->login !== $request->input('login');

        $validated = $request->validate([
            'login' => [
                'required',
                'string',
                'max:255',
                $isLoginChanged ? 'unique:users,login' : 'nullable',
            ],
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $user->update([
            'login' => $validated['login'] ?? $user->login,
            'surname' => $validated['surname'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('user.main')->with('success', 'Данні користувача оновлено успішно !!!');
    }
}
