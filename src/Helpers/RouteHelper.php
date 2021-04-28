<?php

namespace jrmadsen67\LaravelRouteCoverageTest\Helpers;

use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use jrmadsen67\LaravelRouteCoverageTest\Http\Middleware\CollectCodeCoverage;

class RouteHelper
{
    /**
     * Determine the route name based on the route type.
     */
    public static function getRouteName(RoutingRoute $route): string
    {
        if (empty($route)) {
            return '';
        }

        if (!empty($route->getName())) {
            return $route->getName() ?? 'unknown';
        }

        if ($route->getActionName() && $route->getActionName() !== 'Closure') {
            return $route->getActionName();
        }

        return $route->getActionName().' /'.$route->uri();
    }

    /**
     * Determine if the route name provided is to be excluded from the test coverage.
     */
    public static function isExcludedRoute(string $routeName): bool
    {
        // Has to be this way due to PHP's pass by ref array_walk requirements
        $excludedRoutes      = config('route-coverage.exclude_routes', []);
        $excludedRouteGroups = config('route-coverage.exclude_route_groups', []);

        $isExcluded = false;

        array_walk(
            $excludedRoutes,
            function ($excludeName) use ($routeName, &$isExcluded) {
                if ($isExcluded = Str::is($excludeName, $routeName)) {
                    return;
                }
            }
        );

        if ($isExcluded) {
            return $isExcluded;
        }

        array_walk(
            $excludedRouteGroups,
            function ($excludeGroupName) use ($routeName, &$isExcluded) {
                if ($isExcluded = Str::startsWith($routeName, $excludeGroupName.config('route_groups_seperator', '.'))) {
                    return;
                }
            }
        );

        return $isExcluded;
    }

    /**
     * Gathers all the untested routes into a formatted array that can itself be tested and also consumed by the test suite.
     */
    public static function getUntestedRoutes(): array
    {
        $routesTested   = collect(CollectCodeCoverage::$routesTested)->groupBy('name');
        $routesUntested = [];

        foreach (Route::getRoutes() as $route) {
            $routeName = RouteHelper::getRouteName($route);
            $hits      = $routesTested->get($routeName);

            if (self::isExcludedRoute($routeName)) {
                continue;
            }

            foreach ($route->methods() as $method) {
                if ($method === 'HEAD') {
                    continue;
                } elseif ($hits === null || $hits->where('method', '=', $method)->count() === 0) {
                    $routesUntested[] = $routeName.' '.$method;
                }
            }
        }

        asort($routesUntested);

        return $routesUntested;
    }
}
