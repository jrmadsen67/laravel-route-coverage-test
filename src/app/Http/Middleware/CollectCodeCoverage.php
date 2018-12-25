<?php

namespace App\Http\Middleware;

use Closure;

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
                                       'name'   => optional(\Route::getCurrentRoute())->getName() ?? 'unknown',
                                       'method' => $request->getMethod(),
            ];
        }
        return $response;
    }
}
