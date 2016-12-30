<?php

namespace Modules\Category\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Category\Blade\CategoryWidget;
use Modules\Category\Entities\Category;
use Modules\Category\Repositories\Cache\CacheCategoryDecorator;
use Modules\Category\Repositories\CategoryManager;
use Modules\Category\Repositories\CategoryManagerRepository;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Category\Repositories\Eloquent\EloquentCategoryRepository;

class CategoryServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();

        $this->app->singleton('category.widget.directive', function ($app) {
            return new CategoryWidget($app[CategoryRepository::class]);
        });
    }

    public function boot()
    {
        $this->publishConfig('category', 'permissions');
        $this->registerBladeCategories();
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(CategoryRepository::class, function () {
            $repository = new EloquentCategoryRepository(new Category());

            if (! config('app.cache')) {
                return $repository;
            }

            return new CacheCategoryDecorator($repository);
        });

        $this->app->singleton(CategoryManager::class, function () {
            return new CategoryManagerRepository();
        });
    }

    protected function registerBladeCategories()
    {
        if (app()->environment() === 'testing') {
            return;
        }

        $this->app['blade.compiler']->directive('categories', function ($value) {
            return "<?php echo CategoryWidget::show([$value]); ?>";
        });

    }
}
