<?php

namespace Tests\Unit\Api\Discord;

use App\Api\Discord\User;
use App\Api\DiscordApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GetUserTest extends TestCase
{
    private function makeClient(Response ...$responses): Client
    {
        $mock = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mock);

        return new Client(['handler' => $handlerStack]);
    }

    /** @test */
    public function testGetUserSuccess()
    {
        $mockJson = <<<JSON
        {
            "id": "80351110224678912",
            "username": "Nelly",
            "discriminator": "1337",
            "avatar": "8342729096ea3675442027381ff50dfe",
            "verified": true,
            "email": "nelly@discord.com",
            "flags": 64,
            "banner": "06c16474723fe537c283b8efa61a30c8",
            "accent_color": 16711680,
            "premium_type": 1,
            "public_flags": 64
        }
        JSON;


        $client = $this->makeClient(new Response(200, ['Content-Type: application/json'], $mockJson));
        $discordApi = new DiscordApiClient($client, 'example-token');

        $result = $discordApi->getUser('80351110224678912');

        $this->assertEquals(new User(
            '80351110224678912',
            'Nelly',
            '1337',
            '8342729096ea3675442027381ff50dfe',
        ), $result);
    }

    /** @test */
    public function testGetUserNotFound()
    {
        $client = $this->makeClient(new Response(404, ['Content-Type: application/json']));
        $discordApi = new DiscordApiClient($client, 'example-token');

        $result = $discordApi->getUser('99999999999999999999');

        $this->assertEquals(null, $result);
    }

}
