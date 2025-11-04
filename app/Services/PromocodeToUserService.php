<?php

declare(strict_types=1);

namespace App\Services;

use App\Modules\PromocodeToUser\DTO\PromocodeToUserDTO;
use App\Modules\PromocodeToUser\Repositories\PromocodeToUserRepositoryContract;

final readonly class PromocodeToUserService
{
    public function __construct(
        private PromocodeToUserRepositoryContract $promocodeToUserRepository,
    ) {}

    public function create(PromocodeToUserDTO $dto): PromocodeToUserDTO
    {
        return $this->promocodeToUserRepository->create($dto);
    }
}
