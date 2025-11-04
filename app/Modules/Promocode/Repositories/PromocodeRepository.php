<?php

declare(strict_types=1);

namespace App\Modules\Promocode\Repositories;

use App\Models\Promocode;
use App\Modules\Promocode\DTO\PromocodeDTO;
use Throwable;

final readonly class PromocodeRepository implements PromocodeRepositoryContract
{
    /**
     * @throws Throwable
     */
    public function create(PromocodeDTO $dto): Promocode
    {
        $promocode = new Promocode;
        $promocode->fill($dto->toArray());

        $promocode->saveOrFail();

        return $promocode;
    }
}
