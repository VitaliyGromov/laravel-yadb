<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use App\Data\Data;
use Carbon\Carbon;
use Tests\TestCase;

class DataTest extends TestCase
{
    public function test_can_create_data(): void
    {
        $data = new class extends Data
        {
            public function __construct(
                public ?string $name = null,
                public int $age = 12,
                public string $email = 'test@mail.com',
                public Carbon $createdAt = new Carbon('2025-12-23'),
            ) {}
        };

        $result = $data->toArray();
        $this->assertArrayNotHasKey('name', $result);
        $this->assertArrayHasKey('age', $result);
        $this->assertArrayHasKey('email', $result);
        $this->assertArrayHasKey('created_at', $result);
    }
}
