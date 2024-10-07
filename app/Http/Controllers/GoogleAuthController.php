<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Google\Client as GoogleClient;
use Google\Service\PeopleService;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();        //У ДІАЛОГОВОМУ ВІКНІ НЕ ПІДТЯГУЄТЬСЯ ЛОГО
                                                                        //ПОПРАВИТИ ЩОБ ПРАВИЛЬНО БРАЛО ПРІЗВИЩЕ ТА ІМ\Я ПО АРІ
                                                                        //В ДІАЛОГОВОМУ АВТОРИЗАЦІЇ ВІКНІ ПІДТЯГУЄ ТІЛЬКИ ПОТОЧНИЙ АКАУНТ АБО НОВИЙ,
                                                                        //А НА НОУТІ Є БІЛЬШЕ АКАУНТІВ, ВИПРАВИТИ ЦЕ
        $client = new GoogleClient();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(route('google.callback'));
        $client->addScope(PeopleService::USERINFO_PROFILE);
        $client->addScope(PeopleService::USERINFO_EMAIL);
        $client->setAccessToken($googleUser->token);

        $peopleService = new PeopleService($client);
        $googleProfile = $peopleService->people->get('people/me', ['personFields' => 'names,emailAddresses,phoneNumbers,addresses']);

        $surname = !empty($googleProfile->getNames()) ? $googleProfile->getNames()[0]->getDisplayName() : 'Немає імʼя';
        $name = !empty($googleProfile->getNames()) ? $googleProfile->getNames()[0]->getFamilyName() : 'Немає прізвища';
        $email = !empty($googleProfile->getEmailAddresses()) ? $googleProfile->getEmailAddresses()[0]->getValue() : 'Немає пошти';
        $phone = !empty($googleProfile->getPhoneNumbers()) ? $googleProfile->getPhoneNumbers()[0]->getValue() : 'Немає телефону';
        $address = !empty($googleProfile->getAddresses()) ? $googleProfile->getAddresses()[0]->getFormattedValue() : 'Немає адреси';

        $login = Str::replaceLast('@gmail.com', '', $email);

        $user = User::where('email', $email)->first();

        if ($user) {
            Auth::login($user);
        } else {
            $user = User::create([
                'login' => $login,
                'name' => $name,
                'surname' => $surname,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'password' => bcrypt(Str::random(16)),
                'role_id' => 2,
                'google_id' => $googleUser->id,
            ]);

            Auth::login($user);
        }

        if ($user->role_id == 1) {
            return redirect()->route('admin.admin')->with('success', 'Авторизація успішна!');
        }
        elseif ($user->role_id == 2) {
            return redirect()->route('user.main')->with('success', 'Авторизація успішна!');
        }

        return redirect()->route('/')->withErrors('Невідома роль користувача.');
    }
}
