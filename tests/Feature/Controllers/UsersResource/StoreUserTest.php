<?php

namespace Tests\Feature\Controllers\UsersResource;

use App\Models\User;
use App\Values\Users\UserId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class StoreUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testStoreNewUser()
    {
        $identifier = 'cma2819';

        $response = $this->postRequest($identifier);

        $response->isSuccessful();
        $response->assertJson([
            'identifier' => $identifier,
        ]);
        $this->assertDatabaseHas('users', [
            'identifier' => $identifier,
        ]);
    }

    /** @test */
    public function testStoreFailedBecauseDuplicateIdentifier()
    {
        $identifier = 'cma2819';

        User::create(['id' => new UserId(Uuid::uuid4()), 'identifier' => $identifier]);
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
