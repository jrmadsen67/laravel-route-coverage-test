<?php

namespace jrmadsen67\LaravelRouteCoverageTest\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use jrmadsen67\LaravelRouteCoverageTest\Helpers\RouteHelper;

class CollectCodeCoverage
{
    /**
     * Used for code coverage when running unit tests.
     *
     * @var array
     *
     * Register this in your Kernel file in the `$middleware` group!
     */
    public static $routesTested = [];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (app()->runningUnitTests()) {
            static::$routesTested[] = [
                'url'    => $request->getRequestUri(),
                'name'   => RouteHelper::getRouteName(Route::getCurrentRoute()),
                'method' => $request->getMethod(),
            ];
        }

        return $response;
    }
}
