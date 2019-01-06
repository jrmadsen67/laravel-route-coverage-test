<?php

namespace Tests\Unit;

use App\Http\Middleware\CollectCodeCoverage;
use Tests\TestCase;

/**
 *
 * This test class needs to run LAST! PhpUnit will run them in alphabetical order;
 * this is the simplest way to do that
 *
 * Class xCoverageTest
 * @package Tests\Unit
 */
class xCoverageTest extends TestCase {

    public function testCheckAllRoutesTested(){

        $routesTested = CollectCodeCoverage::$routesTested;

        $list = collect($routesTested)->groupBy("name");
        $missingRoutes = [];

        foreach(\Illuminate\Support\Facades\Route::getRoutes() as $route){

            $routeName = $this->getMissingRouteName($route);
            $hits = $list->get($routeName);

            foreach($route->methods() as $method){

                if($method === 'HEAD'){
                    continue;
                }
                else if($hits === null || $hits->where("method", '=', $method)->count() === 0){
                    $missingRoutes[] = $routeName . ' ' . $method;
                }

            }
        }

        asort($missingRoutes);

        $this->assertSame(0, count($missingRoutes), "Missing feature tests for Routes:\n" . implode("\n", $missingRoutes));
    }

    public function getMissingRouteName(\Illuminate\Routing\Route $route)
    {
        if (!empty($route->getName())){
            return $route->getName();
        }

        if ($route->getActionName() && $route->getActionName() !== 'Closure'){
            return $route->getActionName();
        }

        return $route->getActionName() . ' /' . $route->uri();
    }

}
