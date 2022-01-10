<?php

namespace App\Providers;

use App\Models\Action;
use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        JsonResource::withoutWrapping();

        Relation::morphMap([
            'actions' => Action::class,
            'menus' => Menu::class,
            'roles' => Role::class,
            'users' => User::class,
        ]);
    }
}
