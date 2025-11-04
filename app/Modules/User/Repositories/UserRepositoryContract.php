<?php

declare(strict_types=1);

namespace App\Modules\User\Repositories;

use App\Models\User;
use App\Modules\User\DTO\UserDTO;

interface UserRepositoryContract
{
    public function create(UserDTO $userDTO): User;

    public function existsByEmail(string $email): bool;

    public function findByEmail(string $email, array $relations = []): User;

    public function find(string $id, array $relations = []): User;
}
