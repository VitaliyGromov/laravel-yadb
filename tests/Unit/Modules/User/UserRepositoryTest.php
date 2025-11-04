<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\User;

use App\Models\User;
use App\Modules\User\DTO\UserDTO;
use App\Modules\User\Repositories\UserRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    /**
     * @throws BindingResolutionException
     */
    public function test_can_create_user(): void
    {
        $repository = $this->app->make(UserRepository::class);
        $userDto = new UserDto(
            name: $this->faker->name,
            email: $this->faker->email,
            password: $this->faker->password,
        );

        $user = $repository->create($userDto);
        $this->assertDatabaseHas(User::class, [
            'id' => $user->id,
            'name' => $userDto->name,
            'email' => $userDto->email,
        ]);
    }
}
