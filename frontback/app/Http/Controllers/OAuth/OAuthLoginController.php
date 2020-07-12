<?php

namespace App\Http\Controllers\OAuth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthLoginController extends Controller
{
    protected string $sitename;

    public function redirectToProvider()
    {
        return Socialite::driver($this->sitename)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver($this->sitename)->user();
        $existUser = User::where([
            ['email', '=', $user->getEmail()],
        ])->first();
        if (!$existUser) {
            $existUser = User::manualRegistration($user->getNickname(), $user->getEmail());
        }
        Auth::login($existUser, true);
        return redirect('home');
    }
}
