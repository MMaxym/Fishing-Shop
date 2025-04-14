<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('Auth.passwords.email');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('Auth.passwords.reset', ['token' => $token, 'email' => $request->email]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], [
            'email.required' => 'Обовʼязкопе поле.',
            'email.email' => 'Не дійсна електронна пошта.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Користувача з такою електронною адресою не знайдено.',
            ])->withInput();
        }

        $response = Password::sendResetLink($request->only('email'));

        return $response == Password::RESET_LINK_SENT
            ? back()->with('success', 'Посилання для скидання пароля надіслано на вашу електронну адресу.')
            : back()->withErrors(['email' => 'Не вдалося надіслати посилання для скидання пароля.']);
    }


    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required',
            'password_confirmation' => 'required|min:6',
        ], [
            'email.required' => 'Обовʼязкове поле.',
            'email.email' => 'Недійсна електронна пошта.',
            'password.required' => 'Обовʼязкове поле.',
            'password.string' => 'Поле пароль повинно бути рядком.',
            'password.min' => 'Пароль повинен містити щонайменше 6 символів.',
            'password.confirmed' => 'Пароль та підтвердження пароля не співпадають.',
            'password_confirmation.required' => 'Обовʼязкове поле.',
            'password_confirmation.min' => 'Підтвердження пароля повиненно містити щонайменше 6 символів.',
            'auth.failed' => 'Ми не можемо знайти користувача з такою електронною адресою.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Користувача з такою електронною адресою не знайдено.',
            ])->withInput();
        }

        $response = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        return $response == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Пароль оновлено успішно.')
            : back()->withErrors(['email' => trans($response)]);
    }
}
