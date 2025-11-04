<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\CreateUserException;
use App\Models\User;
use App\Modules\User\DTO\UserDTO;
use App\Modules\User\Repositories\UserRepositoryContract;
use Illuminate\Support\Facades\Log;
use Throwable;

final readonly class UserService
{
    public function __construct(
        private UserRepositoryContract $userRepository,
    ) {}

    /**
     * @throws CreateUserException
     */
    public function create(UserDTO $userDTO): User
    {
        try {
            return $this->userRepository->create($userDTO);
        } catch (Throwable $exception) {
            Log::error('При создании пользователя прозошла ошибка: ' . $exception->getMessage(), [
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'class' => self::class,
                'method' => __METHOD__,
            ]);

            throw new CreateUserException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function find(string $id, array $relations = []): User
    {
        return $this->userRepository->find($id, $relations);
    }

    public function findByEmail(string $email, array $relations = []): User
    {
        return $this->userRepository->findByEmail($email, $relations);
    }

    public function existsByEmail(string $email): bool
    {
        return $this->userRepository->existsByEmail($email);
    }
}
