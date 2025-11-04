<?php

declare(strict_types=1);

namespace App\Modules\Promocode\Repositories;

use App\Models\Promocode;
use App\Modules\Promocode\DTO\PromocodeDTO;

interface PromocodeRepositoryContract
{
    public function create(PromocodeDTO $dto): Promocode;
}
