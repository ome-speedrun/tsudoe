<?php

namespace Tests\Feature\Controllers\UsersResource;

use App\Models\User;
use App\Values\Users\Identifier;
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

    private const TARGET_IDENTIFIER = 'cma2819';
    private const NOT_TARGET_IDENTIFIER = 'hoge1234';
    private const NOT_EXISTS_IDENTIFIER = 'john_yay';

    protected function setUp(): void
    {
        parent::setUp();

        UserFactory::make(
            userId: new UserId(self::TARGET_USER_ID),
            identifier: new Identifier(self::TARGET_IDENTIFIER),
        )->save();
        UserFactory::make(
            userId: new UserId(self::NOT_TARGET_USER_ID),
            identifier: new Identifier(self::NOT_TARGET_IDENTIFIER),
        )->save();
    }

    /**
     * @test
     * @dataProvider provideIdentifier
     */
    public function testShowUser(string $identifier)
    {
        $response = $this->getRequest($identifier);

        $response->assertSuccessful();
        $response->assertJson([
            'id' => self::TARGET_USER_ID,
            'identifier' => self::TARGET_IDENTIFIER,
        ]);
    }

    public function provideIdentifier(): array
    {
        return [
            'Find by ID' => [self::TARGET_USER_ID],
            'Find by identifier' => [self::TARGET_IDENTIFIER],
        ];
    }

    /**
     * @test
     * @dataProvider provideNotFoundIdentifier
     */
    public function testUserNotFound(string $identifier)
    {
        $response = $this->getRequest($identifier);

        $response->assertNotFound();
    }

    public function provideNotFoundIdentifier(): array
    {
        return [
            'by ID' => [self::NOT_EXISTS_USER_ID],
            'by identifier' => [self::NOT_EXISTS_IDENTIFIER],
        ];
    }

    private function getRequest(string $id): TestResponse
    {
        return $this->getJson(route('users.show', ['id' => $id]));
    }
}
