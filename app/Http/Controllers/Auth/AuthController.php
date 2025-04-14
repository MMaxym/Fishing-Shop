<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|unique:users|max:255',
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'full_phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ], [
            'login.required' => 'Обовʼязкове поле.',
            'login.unique' => 'Користувач з таким логіном вже існує.',
            'login.max' => 'Логін не повинен перевищувати 255 символів.',

            'surname.required' => 'Обовʼязкове поле.',
            'surname.string' => 'Прізвище повинно бути рядком.',
            'surname.max' => 'Прізвище не повинно перевищувати 255 символів.',

            'name.required' => 'Обовʼязкове поле.',
            'name.string' => 'Імʼя повинно бути рядком.',
            'name.max' => 'Імʼя не повинно перевищувати 255 символів.',

            'email.required' => 'Обовʼязкове поле.',
            'email.email' => 'Недійсна електронна пошта.',
            'email.unique' => 'Користувач з такою електронною поштою вже існує.',

            'password.required' => 'Обовʼязкове поле.',
            'password.string' => 'Поле пароль повинно бути рядком.',
            'password.min' => 'Пароль повинен містити щонайменше 6 символів.',
            'password.confirmed' => 'Пароль та підтвердження пароля не співпадають.',

            'password_confirmation.required' => 'Обовʼязкове поле.',
            'password_confirmation.min' => 'Підтвердження пароля повинно містити щонайменше 6 символів.',

            'full_phone.required' => 'Обовʼязкове поле.',
            'full_phone.string' => 'Телефон повинен бути рядком.',
            'full_phone.max' => 'Телефон не повинен перевищувати 255 символів.',

            'address.required' => 'Обовʼязкове поле.',
            'address.string' => 'Адреса повинна бути рядком.',
            'address.max' => 'Адреса не повинна перевищувати 255 символів.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'login' => $request->login,
            'password' => Hash::make($request->input('password')),
            'surname' => $request->surname,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->full_phone,
            'address' => $request->address,
            'role_id' => 2,
        ]);

        return redirect()->route('login')->with('success', 'Реєстрація успішна!');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Обовʼязкопе поле.',
            'email.email' => 'Не дійсна електронна пошта.',
            'password.required' => 'Обовʼязкопе поле.',
            'password.string' => 'Поле пароль повинно бути рядком.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Користувача з такою електронною адресою не знайдено.',
            ])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Невірний пароль.',
            ])->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->role_id == 1) {
            return redirect()->route('admin.admin')->with('success', 'Авторизація успішна!');
        }
        elseif ($user->role_id == 2) {
            return redirect()->route('user.main')->with('success', 'Авторизація успішна!');
        }

        return redirect()->route('/')->withErrors('Невідома роль користувача.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.main')->with('success', 'Ви успішно вийшли з акаунту!');
    }
}
