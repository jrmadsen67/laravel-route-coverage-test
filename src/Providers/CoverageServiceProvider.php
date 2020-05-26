<?php
/**
 * CoverageServiceProvider.php
 *
 * This provider will publish the required files in the required directories.
 *
 * PHP version 7.0
 *
 * @category Providers
 * @package  laravelRouteCoverageTest
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/jrmadsen67/laravel-route-coverage-test
 * @since    GIT:1.1
 */

namespace jrmadsen67\LaravelRouteCoverageTest\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class TrackerServiceProvider
 *
 * @category Providers
 * @package  laravelRouteCoverageTest
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/jrmadsen67/laravel-route-coverage-test
 * @since    GIT:1.1
 */
class CoverageServiceProvider extends ServiceProvider
{

    /**
     * Register the publishable files.
     *
     * @return void
     */
    private function registerPublishableResources()
    {
        $path = dirname(__DIR__).'/../publishable';

        $publishable = [
          'app' => [
            "{$path}/app/Http/Middleware/CollectCodeCoverage.php" => app_path(
              'Http/Middleware/CollectCodeCoverage.php'
            ),
          ],
          'tests' => [
            "{$path}/tests/Feature/xCoverageTest.php" => $this->tests_path(
              'Feature/xCoverageTest.php'
            ),
          ]
        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }

    protected function tests_path($path)
    {
        $realPath = realpath(app()->path('../tests/'));
        return $realPath.'/'.$path;
    }

    /**
     * Register publishable files.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishableResources();
        }
    }

    /**
     * Tell Laravel where to look for the package it's migrations.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        $router->middleware('laravel-route-coverage-test', \App\App\Http\Middleware\CollectCodeCoverage::class);
    }
}