<?php

declare(strict_types=1);

namespace App\Modules\User\DTO;

use App\Data\Data;
use Carbon\Carbon;

final class UserDTO extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly ?string $id = null,
        public readonly ?Carbon $createdAt = null,
        public readonly ?Carbon $updatedAt = null,
    ) {}
}
