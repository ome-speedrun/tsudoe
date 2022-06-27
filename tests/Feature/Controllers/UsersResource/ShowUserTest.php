<?php

namespace Tests\Feature\Controllers\UsersResource;

use App\Models\User;
use App\Values\Users\UserId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\Fixtures\Factories\UserFactory;
use Tests\TestCase;

class ShowUserTest extends TestCase
{
    use RefreshDatabase;

    private const TARGET_USER_ID = '977db207-1c0d-4314-ada2-9acd57c17cbb';
    private const NOT_TARGET_USER_ID = '456fab50-d4c8-44c5-8453-3f0bd79fd8ce';
    private const NOT_EXISTS_USER_ID = '2af9f855-7621-4fa3-b86e-2752e4bcfe5a';

    protected function setUp(): void
    {
        parent::setUp();

        UserFactory::make(userId: new UserId(self::TARGET_USER_ID))->save();
        UserFactory::make(userId: new UserId(self::NOT_TARGET_USER_ID))->save();
    }

    /** @test */
    public function testShowUser()
    {
        $response = $this->getRequest(self::TARGET_USER_ID);

        $response->isSuccessful();
        $response->assertJson([
            'id' => self::TARGET_USER_ID,
        ]);
    }

    /** @test */
    public function testUserNotFound()
    {
        $response = $this->getRequest(self::NOT_EXISTS_USER_ID);

        $response->assertNotFound();
    }

    private function getRequest(string $id): TestResponse
    {
        return $this->getJson(route('users.show', ['id' => $id]));
    }
}
