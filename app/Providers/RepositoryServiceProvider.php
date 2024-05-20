<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\CategoryInterface;
use App\Repositories\CategoryRepository;

use App\Interfaces\ProductInterface;
use App\Repositories\ProductRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // $app->bind(CategoryInterface::class, CategoryRepository::class);
    }
}
