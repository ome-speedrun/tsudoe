<?php

namespace App\Api\Discord;

class User
{
    public function __construct(
        public readonly string $id,
        public readonly string $username,
        public readonly string $discriminator,
        public readonly ?string $avatar,
    ) {}

    public static function fromJson(
        string $json
    ): static {
        $obj = json_decode($json);

        return new static(
            $obj->id,
            $obj->username,
            $obj->discriminator,
            $obj?->avatar,
        );
    }
}
