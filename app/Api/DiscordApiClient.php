<?php

namespace App\Api;

use App\Api\Discord\DiscordApiException;
use App\Api\Discord\User;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class DiscordApiClient
{
    public function __construct(
        protected Client $httpClient,
        protected string $botToken,
    ) {}

    public function getUser(string $userId): ?User
    {
        $response = $this->requestGet('users/' . $userId);

        if ($response->getStatusCode() === 200) {
            return User::fromJson($response->getBody());
        }

        if ($response->getStatusCode() === 404) {
            return null;
        }

        throw new DiscordApiException(
            'Unexpected status=' . $response->getStatusCode() . ' to /users',
        );
    }

    protected function requestGet(
        string $path,
        array $query = []
    ): ResponseInterface {
        $response = $this->httpClient->get($path, [
            'headers' => [
                'Authorization' => 'Bot ' . $this->botToken,
            ],
            'query' => $query,
            'http_errors' => false,
        ]);

        return $response;
    }
}
