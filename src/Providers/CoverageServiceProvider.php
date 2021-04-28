<?php

namespace jrmadsen67\LaravelRouteCoverageTest\Providers;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use jrmadsen67\LaravelRouteCoverageTest\Http\Middleware\CollectCodeCoverage;

/**
 * CoverageServiceProvider.php.
 *
 * This provider will publish the required files in the required directories.
 *
 * PHP version 7.0
 *
 * @category Providers
 *
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 *
 * @see     https://github.com/jrmadsen67/laravel-route-coverage-test
 * @since    GIT:1.1
 */
class CoverageServiceProvider extends ServiceProvider
{
    /**
     * Helper for the base directory for all the supplimentary package stuff.
     */
    const PACKAGE_RESOURCE_DIR = __DIR__.'/../../publishable';

    /**
     * Tell Laravel where to look for the package it's migrations.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // Register the middleware globally
        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(CollectCodeCoverage::class);

        // Publishing is only necessary when using the CLI
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            self::PACKAGE_RESOURCE_DIR.'/config/route-coverage.php' => config_path('route-coverage.php'),
        ], 'config');

        // Publishing the tests.
        $this->publishes([
            self::PACKAGE_RESOURCE_DIR.'/tests/Feature/zRouteCoverageTest.php' => tests_path('Feature/zRouteCoverageTest.php'),
        ], 'tests');
    }

    /**
     * Register publishable files.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            self::PACKAGE_RESOURCE_DIR.'/config/route-coverage.php',
            'route-coverage'
        );
    }
}
