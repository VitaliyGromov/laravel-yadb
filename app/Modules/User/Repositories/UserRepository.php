<?php

declare(strict_types=1);

namespace App\Modules\User\Repositories;

use App\Models\User;
use App\Modules\User\DTO\UserDTO;

final readonly class UserRepository implements UserRepositoryContract
{
    public function __construct(
        private User $user
    ) {}

    public function create(UserDTO $userDTO): User
    {
        $user = new User;
        $user->fill($userDTO->toArray());

        $user->saveOrFail();

        return $user;
    }

    public function existsByEmail(string $email): bool
    {
        return $this->user->newQuery()
            ->where('email', $email)
            ->exists();
    }

    public function findByEmail(string $email, array $relations = []): User
    {
        return $this->user->newQuery()
            ->with($relations)
            ->where('email', $email)
            ->firstOrFail();

    }

    public function find(string $id, array $relations = []): User
    {
        return $this->user->newQuery()
            ->with($relations)
            ->findOrFail($id);
    }
}
