<?php

declare(strict_types=1);

namespace App\Providers;

use App\Modules\Promocode\Repositories\PromocodeRepository;
use App\Modules\Promocode\Repositories\PromocodeRepositoryContract;
use App\Modules\PromocodeToUser\Repositories\PromocodeToUserRepository;
use App\Modules\PromocodeToUser\Repositories\PromocodeToUserRepositoryContract;
use App\Modules\User\Repositories\UserRepository;
use App\Modules\User\Repositories\UserRepositoryContract;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        foreach ($this->bindings() as $abstract => $concrete) {
            $this->app->bind($abstract, function() use ($concrete) {
                return $this->app->make($concrete);
            });
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    private function bindings(): array
    {
        return [
            UserRepositoryContract::class => UserRepository::class,
            PromocodeRepositoryContract::class => PromocodeRepository::class,
            PromocodeToUserRepositoryContract::class => PromocodeToUserRepository::class,
        ];
    }
}
