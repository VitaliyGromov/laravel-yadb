<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Promocode;
use App\Modules\Promocode\DTO\PromocodeDTO;
use App\Modules\Promocode\Repositories\PromocodeRepository;

final readonly class PromocodeService
{
    public function __construct(
        private PromocodeRepository $promocodeRepository,
    ) {}

    /**
     * @throws \Throwable
     */
    public function create(PromocodeDTO $dto): Promocode
    {
        return $this->promocodeRepository->create($dto);
    }
}
