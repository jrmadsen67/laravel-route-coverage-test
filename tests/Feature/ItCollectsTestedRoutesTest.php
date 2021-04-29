<?php

namespace Tests\Feature;

use jrmadsen67\LaravelRouteCoverageTest\Http\Middleware\CollectCodeCoverage;
use Tests\TestCase;

class ItCollectsTestedRoutesTest extends TestCase
{
    /**
     * Manually reset the collected routes between tests.
     */
    public function setUp(): void
    {
        parent::setUp();

        CollectCodeCoverage::$routesTested = [];
    }

    public function test_the_middleware_collects_named_tested_routes(): void
    {
        // Given some routes
        $this->setupTestingRoutes();

        // When a route is called
        $this->get('_named_test/one');

        // Then the route should be collected into the tested routes array
        $this->assertContains(
            [
                'url'    => '/_named_test/one',
                'name'   => 'testing.one',
                'method' => 'GET',
            ],
            CollectCodeCoverage::$routesTested
        );
    }

    public function test_the_middleware_collects_closue_tested_routes(): void
    {
        // Given some routes
        $this->setupTestingRoutes();

        // When a route is called
        $this->get('_test/three');

        // Then the route should be collected into the tested routes array
        $this->assertContains(
            [
                'url'    => '/_test/three',
                'name'   => 'Closure /_test/three',
                'method' => 'GET',
            ],
            CollectCodeCoverage::$routesTested
        );
    }
}
