<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\User;
use App\Modules\User\DTO\UserDTO;
use App\Services\UserService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    /**
     * @throws BindingResolutionException
     */
    public function test_can_handle_create_user(): void
    {
        $service = $this->app->make(UserService::class);

        $userDto = new UserDto(
            name: $this->faker->name,
            email: $this->faker->email,
            password: $this->faker->password,
        );

        $user = $service->create($userDto);

        $this->assertDatabaseHas(User::class, [
            'id' => $user->id,
            'name' => $userDto->name,
            'email' => $userDto->email,
        ]);
    }
}
