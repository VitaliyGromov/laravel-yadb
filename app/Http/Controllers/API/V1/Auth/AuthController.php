<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1\Auth;

use App\Exceptions\CreateUserException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use App\Http\Requests\API\V1\Auth\LogoutRequest;
use App\Http\Requests\API\V1\Auth\RegisterRequest;
use App\Modules\User\DTO\UserDTO;
use App\Services\Managers\Auth\AuthManager;
use App\Services\Managers\Auth\Data\LoginDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

final class AuthController extends Controller
{
    public function __construct(
        private AuthManager $authManager,
    ) {}

    /**
     * @throws CreateUserException
     * @throws Throwable
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $userDTO = new UserDTO(
            $validated['name'],
            $validated['email'],
            $validated['password'],
        );

        return new JsonResponse([
            'token' => $this->authManager->registerUser($userDTO),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $dto = new LoginDTO(
            $validated['email'],
            $validated['password'],
        );

        return new JsonResponse([
            'token' => $this->authManager->loginUser($dto),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function logout(LogoutRequest $request): Response
    {
        $this->authManager->logoutUser(
            $request->validated('user_id')
        );

        return response()->noContent();
    }
}
