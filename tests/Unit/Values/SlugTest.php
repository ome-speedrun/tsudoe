<?php

namespace Tests\Unit\Values;

use App\Exceptions\Values\InvalidValueException;
use App\Values\Events\Slug;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class SlugTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideInvalidSlugs
     */
    public function testInvalid(string $value)
    {
        $this->expectException(InvalidValueException::class);

        new Slug($value);
    }

    public function provideInvalidSlugs(): array
    {
        return [
            '大文字を含む' => ['Test-slug'],
            '日本語を含む' => ['あtest-slug'],
            'スネークケース' => ['test_slug'],
            '短すぎる' => [Str::repeat('a', Slug::MIN_LENGTH - 1)],
            '長すぎる' => [Str::repeat('a', Slug::MAX_LENGTH + 1)],
        ];
    }
}
