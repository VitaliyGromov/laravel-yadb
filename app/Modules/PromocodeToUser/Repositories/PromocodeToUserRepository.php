<?php

declare(strict_types=1);

namespace App\Modules\PromocodeToUser\Repositories;

use App\Models\PromocodeToUser;
use App\Modules\PromocodeToUser\DTO\PromocodeToUserDTO;
use Throwable;

final class PromocodeToUserRepository implements PromocodeToUserRepositoryContract
{
    /**
     * @throws Throwable
     */
    public function create(PromocodeToUserDTO $dto): PromocodeToUser
    {
        $pomocodeToUser = new PromocodeToUser;
        $pomocodeToUser->fill($dto->toArray());

        $pomocodeToUser->saveOrFail();

        return $pomocodeToUser;
    }
}
