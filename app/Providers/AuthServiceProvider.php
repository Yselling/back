<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Gender;
use App\Models\Media;
use App\Models\Product;
use App\Models\Role;
use App\Policies\CartPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\GenderPolicy;
use App\Policies\MediaPolicy;
use App\Policies\ProductPolicy;
use App\Policies\RolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        Gender::class => GenderPolicy::class,
        Role::class => RolePolicy::class,
        Category::class => CategoryPolicy::class,
        Product::class => ProductPolicy::class,
        Media::class => MediaPolicy::class,
        Cart::class => CartPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
