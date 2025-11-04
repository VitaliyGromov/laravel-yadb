<?php

declare(strict_types=1);

namespace App\Services\Managers\Auth\Data;

use App\Data\Data;

final class LoginDTO extends Data
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}
}
