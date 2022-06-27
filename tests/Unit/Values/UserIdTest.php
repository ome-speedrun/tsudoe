<?php

namespace Tests\Unit\Values;

use App\Exceptions\Values\InvalidValueException;
use App\Values\Users\UserId;
use PHPUnit\Framework\TestCase;

class UserIdTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideInvalidRawId
     */
    public function testInvalidUserId(string $raw)
    {
        $this->expectException(InvalidValueException::class);

        new UserId($raw);
    }

    public function provideInvalidRawId(): array
    {
        return [
            'Not UUID' => ['17319943d6314abeafe6b36f840d63c3'],
            'Out of range character included' => ['17319943-d631-4abe-afe6-b36f840d63cg'],
        ];
    }
}
