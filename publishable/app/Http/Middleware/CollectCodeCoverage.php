<?php

namespace App\Http\Middleware;

use Closure;
use Route;

class CollectCodeCoverage {

    /**
     * Used for code coverage when running unit tests
     * @var array
     *
     * Register this in your Kernel file in the `$middleware` group!
     */
    static $routesTested = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $response = $next($request);

        if(app()->runningUnitTests()){
            // Record code coverage
            static::$routesTested[] = ['url'    => $request->getRequestUri(),
                                       'name'   => $this->getRouteName(Route::getCurrentRoute()) ?? 'unknown',
                                       'method' => $request->getMethod(),
            ];
        }
        return $response;
    }

    protected function getRouteName($route){

        if (empty($route)) {
            return '';
        }
        
        if (!empty($route->getName())){
            return $route->getName();
        }

        if ($route->getActionName() && $route->getActionName() !== 'Closure'){
            return $route->getActionName();
        }

        return $route->getActionName() . ' /' . $route->uri();
    }

}
