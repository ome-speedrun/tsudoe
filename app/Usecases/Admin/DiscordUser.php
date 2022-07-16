<?php

namespace App\Usecases\Admin;

use Laravel\Socialite\Contracts\User;

class DiscordUser
{
    public function __construct(
        public readonly string $id,
        public readonly string $username,
        public readonly string $discriminator,
        public readonly string $avatar,
    ) {
    }

    public static function fromSocialite(User $socialite): static
    {
        [$_, $discriminator] = explode('#', $socialite->getNickname());
        return new static(
            $socialite->getId(),
            $socialite->getName(),
            $discriminator,
            $socialite->getAvatar(),
        );
    }
}
