<?php

namespace App\Providers;

use App\Api\DiscordApiClient;
use GuzzleHttp\Client;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            DiscordApiClient::class,
            function () {
                return new DiscordApiClient(
                    new Client(['base_uri' => config('services.discord.api_url')]),
                    config('services.discord.bot_token'),
                );
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
    }
}
