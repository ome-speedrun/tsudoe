<?php

namespace Tests\Feature\Controllers\UsersResource;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class StoreUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testStoreNewUser()
    {
        $identifier = '8e11918b-44d0-4960-b00c-9201805ae23c';

        $response = $this->postRequest($identifier);

        $response->isSuccessful();
        $response->assertJson([
            'id' => $identifier,
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $identifier,
        ]);
    }

    /** @test */
    public function testStoreFailedBecauseDuplicateIdentifier()
    {
        $identifier = '8e11918b-44d0-4960-b00c-9201805ae23c';

        User::create(['id' => $identifier]);
        $response = $this->postRequest($identifier);

        $response->assertStatus(422);
    }

    private function postRequest(string $identifier): TestResponse
    {
        return $this->postJson(route('users.store'), [
            'identifier' => $identifier,
        ]);
    }
}
