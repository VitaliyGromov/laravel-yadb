<?php

declare(strict_types=1);

namespace App\Modules\PromocodeToUser\DTO;

use App\Data\Data;
use Carbon\Carbon;

final class PromocodeToUserDTO extends Data
{
    public function __construct(
        public readonly string $userId,
        public readonly string $promocodeId,
        public readonly ?string $id = null,
        public readonly ?Carbon $createdAt = null,
        public readonly ?Carbon $updatedAt = null,
    ) {}
}
