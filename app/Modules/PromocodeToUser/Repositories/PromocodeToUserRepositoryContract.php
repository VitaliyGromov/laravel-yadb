<?php

declare(strict_types=1);

namespace App\Modules\PromocodeToUser\Repositories;

use App\Models\PromocodeToUser;
use App\Modules\PromocodeToUser\DTO\PromocodeToUserDTO;

interface PromocodeToUserRepositoryContract
{
    public function create(PromocodeToUserDTO $dto): PromocodeToUser;
}
