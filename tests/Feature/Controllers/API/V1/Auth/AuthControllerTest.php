<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\API\V1\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    #[DataProvider('cannotLoginData')]
    public function test_cannot_login(callable $generator): void
    {
        ['payload' => $payload, 'code' => $code] = $generator($this);

        $response = $this->postJson('/api/v1/auth/login', $payload);
        $response->assertStatus($code);
    }

    public static function cannotLoginData(): array
    {
        return [
            'user does not exist' => [
                function(self $context) {
                    return [
                        'payload' => [
                            'email' => $context->faker()->email(),
                            'password' => $context->faker()->password(10),
                        ],
                        'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    ];
                },
            ],
            'wrong password' => [
                function(self $context) {
                    $user = User::factory()->create();

                    return [
                        'payload' => [
                            'email' => $user->email,
                            'password' => $context->faker()->password(10),
                        ],
                        'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    ];
                },
            ],
            'wrong email' => [
                function(self $context) {
                    $password = $context->faker()->password(10);
                    User::factory()->create([
                        'password' => $password,
                    ]);

                    return [
                        'payload' => [
                            'email' => $context->faker()->email(),
                            'password' => $password,
                        ],
                        'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    ];
                },
            ],
            'email is not valid' => [
                function(self $context) {
                    return [
                        'payload' => [
                            'email' => $context->faker()->word(),
                            'password' => $context->faker()->password(10),
                        ],
                        'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    ];
                },
            ],
        ];
    }

    public function test_can_login(): void
    {
        $password = $this->faker->password(10);
        $user = User::factory()->create([
            'password' => $password,
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'token',
        ]);
    }

    #[DataProvider('cannotRegisterData')]
    public function test_cannot_register(callable $generator): void
    {
        $response = $this->postJson('/api/v1/auth/register', $generator($this));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function cannotRegisterData(): array
    {
        return [
            'name is empty' => [
                function(self $context) {
                    $password = $context->faker()->password(10);

                    return [
                        'email' => $context->faker()->email(),
                        'password' => $password,
                        'password_confirmation' => $password,
                    ];
                },
            ],
            'email is empty' => [
                function(self $context) {
                    $password = $context->faker()->password(10);

                    return [
                        'name' => $context->faker()->name(),
                        'password' => $password,
                        'password_confirmation' => $password,
                    ];
                },
            ],
            'email is not valid' => [
                function(self $context) {
                    $password = $context->faker()->password(10);

                    return [
                        'name' => $context->faker()->name(),
                        'email' => $context->faker()->word(),
                        'password' => $password,
                        'password_confirmation' => $password,
                    ];
                },
            ],
            'email is already in use' => [
                function(self $context) {
                    $password = $context->faker()->password(10);
                    $user = User::factory()->create();

                    return [
                        'name' => $context->faker()->name(),
                        'email' => $user->email,
                        'password' => $password,
                        'password_confirmation' => $password,
                    ];
                },
            ],
            'password is not confirmed' => [
                function(self $context) {
                    $password = $context->faker()->password(10);

                    return [
                        'name' => $context->faker()->name(),
                        'email' => $context->faker()->email(),
                        'password' => $password,
                    ];
                },
            ],
        ];
    }

    public function test_can_register(): void
    {
        $password = $this->faker->password(10);
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $password,
            'password_confirmation' => $password,
        ];
        $response = $this->postJson('/api/v1/auth/register', $data);
        $response->assertOk();
        $response->assertJsonStructure([
            'token',
        ]);

        $this->assertDatabaseHas(User::class, [
            'email' => $data['email'],
        ]);
    }

    public function test_can_logout(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'web');

        $response = $this->postJson('/api/v1/auth/logout');
        $response->assertNoContent();
    }
}
