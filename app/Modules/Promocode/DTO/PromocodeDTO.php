<?php

declare(strict_types=1);

namespace App\Modules\Promocode\DTO;

use App\Data\Data;
use Carbon\Carbon;

final class PromocodeDTO extends Data
{
    public function __construct(
        public readonly string $userId,
        public readonly string $promocodeId,
        public readonly string $code,
        public readonly ?Carbon $createdAt = null,
        public readonly ?Carbon $updatedAt = null,
        public readonly ?string $id = null
    ) {}
}
