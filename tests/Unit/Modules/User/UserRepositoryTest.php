<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\User;

use App\Models\User;
use App\Modules\User\DTO\UserDTO;
use App\Modules\User\Repositories\UserRepositoryContract;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    protected UserRepositoryContract $userRepository;

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = app()->make(UserRepositoryContract::class);
    }

    public function test_can_create_user(): void
    {
        $userDto = new UserDto(
            name: $this->faker->name,
            email: $this->faker->email,
            password: $this->faker->password,
        );

        $user = $this->userRepository->create($userDto);
        $this->assertDatabaseHas(User::class, [
            'id' => $user->id,
            'name' => $userDto->name,
            'email' => $userDto->email,
        ]);
    }

    public function test_can_find_user_by_email(): void
    {
        $user = User::factory()->create();

        $findUser = $this->userRepository->findByEmail($user->email);
        $this->assertEquals($user->id, $findUser->id);
    }

    public function test_throws_exception_when_user_does_not_exist(): void
    {
        $this->expectException(ModelNotFoundException::class);

        User::factory()->create();
        $this->userRepository->findByEmail($this->faker->email);
    }
}
