<?php

namespace Tests;

use Illuminate\Support\Facades\Route;
use jrmadsen67\LaravelRouteCoverageTest\Providers\CoverageServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Any service providers that the test may require.
     */
    protected function getPackageProviders($app): array
    {
        return [
            CoverageServiceProvider::class,
        ];
    }

    /**
     * Copies across the testing routes to the testing application.
     */
    protected function setupTestingRoutes(): void
    {
        Route::group([
            'prefix' => '_named_test',
            'as'     => 'testing.',
        ], function () {
            Route::name('one')
                ->get('one', function () {
                    return response()->noContent();
                });

            Route::name('two')
                ->get('two', function () {
                    return response()->noContent();
                });
        });

        Route::group([
            'prefix' => '_test',
        ], function () {
            Route::get('three', function () {
                return response()->noContent();
            });

            Route::get('four', function () {
                return response()->noContent();
            });
        });
    }
}
