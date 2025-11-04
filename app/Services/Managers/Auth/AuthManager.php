<?php

declare(strict_types=1);

namespace App\Services\Managers\Auth;

use App\Models\User;
use App\Modules\User\DTO\UserDTO;
use App\Services\Managers\Auth\Data\LoginDTO;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class AuthManager
{
    private const string AUTH_TOKEN_NAME = 'authToken';

    public function __construct(
        private UserService $userService,
    ) {}

    /**
     * @throws Throwable
     */
    public function registerUser(UserDTO $dto): string
    {
        return DB::transaction(function() use ($dto) {
            $user = $this->userService->create($dto);

            return $this->createAccessTokenString($user);
        });
    }

    /**
     * @throws Throwable
     */
    public function loginUser(LoginDTO $dto): string
    {
        return DB::transaction(function() use ($dto) {
            $user = $this->userService->findByEmail($dto->email, ['tokens']);
            $this->deleteAccessToken($user);

            return $this->createAccessTokenString($user);
        });
    }

    /**
     * @throws Throwable
     */
    public function logoutUser(string $id): void
    {
        DB::transaction(function() use ($id) {
            $user = $this->userService->find($id, ['tokens']);
            $this->deleteAccessToken($user);
        });
    }

    private function createAccessTokenString(User $user): string
    {
        return $user->createToken(self::AUTH_TOKEN_NAME)->plainTextToken;
    }

    private function deleteAccessToken(User $user): void
    {
        $user->tokens()->where('name', self::AUTH_TOKEN_NAME)->delete();
    }
}
