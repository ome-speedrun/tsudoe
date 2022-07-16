<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Usecases\Admin\AuthenticateAdministrator;
use App\Usecases\Admin\DiscordUser;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;

class DiscordAuthController extends Controller
{
    public function login(
        SocialiteFactory $socialite,
    )
    {
        return $socialite->driver('discord')->redirect();
    }

    /**
     * @param StatefulGuard $auth
     * @param AuthenticateAdministrator $authenticateAdministrator
     */
    public function callback(
        Guard $auth,
        SocialiteFactory $socialite,
        AuthenticateAdministrator $authenticateAdministrator,
    ) {
        $discordUser = $socialite->driver('discord')->user();

        $administrator = $authenticateAdministrator->execute(DiscordUser::fromSocialite($discordUser));

        if (!$administrator) {
            return redirect(route('admin.login'))->withErrors('登録されていないDiscordユーザーです.');
        }

        $auth->login($administrator);

        return redirect(route('admin.applications'));
    }

    /**
     * @param StatefulGuard $auth
     */
    public function logout(
        Guard $auth,
    ) {
        $auth->logout();

        return redirect(route('admin.login'));
    }
}
