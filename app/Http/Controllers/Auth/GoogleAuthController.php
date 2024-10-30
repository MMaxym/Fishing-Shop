<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Google\Client as GoogleClient;
use Google\Service\PeopleService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

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
        try {
            $googleUser = Socialite::driver('google')->user();

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

            if ($user->role_id == 1)
            {
                return redirect()->route('admin.admin')->with('success', 'Авторизація успішна!');
            }
            elseif ($user->role_id == 2)
            {
                return redirect()->route('user.main')->with('success', 'Авторизація успішна!');
            }

            return redirect()->route('/')->withErrors('Невідома роль користувача.');
        }
        catch (\Laravel\Socialite\Two\InvalidStateException $e)
        {
            return redirect()->route('login')->withErrors('Авторизацію було скасовано.');
        }
        catch (\Exception $e)
        {
            return redirect()->route('login')->withErrors('Авторизацію було скасовано.');
        }
    }
}
