<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;
use jrmadsen67\LaravelRouteCoverageTest\Helpers\RouteHelper;
use jrmadsen67\LaravelRouteCoverageTest\Http\Middleware\CollectCodeCoverage;
use Tests\TestCase;

class ItHasTheExpectedTestingCriteriaTest extends TestCase
{
    /**
     * Manually reset the collected routes between tests.
     */
    public function setUp(): void
    {
        parent::setUp();

        CollectCodeCoverage::$routesTested = [];
    }

    public function test_it_generates_the_test_criteria_for_not_hit_routes(): void
    {
        // Given some routes
        $this->setupTestingRoutes();

        // When a route is called
        $this->get('_named_test/one');

        // When the test suite executes the method to gather the non-hit routes
        $routesUntested = RouteHelper::getUntestedRoutes();

        // Then the hit routes should not be collected into the untested routes array...
        $this->assertNotContains('testing.one GET', $routesUntested);

        // ...and only the non-hit routes should be collected into the untested routes array
        $this->assertContains('testing.two GET', $routesUntested);
        $this->assertContains('Closure /_test/three GET', $routesUntested);
        $this->assertContains('Closure /_test/four GET', $routesUntested);
    }

    public function test_it_generates_the_test_criteria_for_not_hit_routes_excluding_individual_named_routes(): void
    {
        // Given some routes
        $this->setupTestingRoutes();

        // Given the config stating not to collect a route
        Config::set('route-coverage.exclude_routes', ['testing.one']);

        // When a route is called
        $this->get('_named_test/two');

        // When the test suite executes the method to gather the non-hit routes
        $routesUntested = RouteHelper::getUntestedRoutes();

        // Then the hit routes and excluded routes should not be collected into the untested routes array...
        $this->assertNotContains('testing.one GET', $routesUntested);
        $this->assertNotContains('testing.two GET', $routesUntested);

        // ...and only the non-hit and included routes should be collected into the untested routes array
        $this->assertContains('Closure /_test/three GET', $routesUntested);
        $this->assertContains('Closure /_test/four GET', $routesUntested);
    }

    public function test_it_generates_the_test_criteria_for_not_hit_routes_excluding_individual_unnamed_routes(): void
    {
        // Given some routes
        $this->setupTestingRoutes();

        // Given the config stating not to collect a route
        Config::set('route-coverage.exclude_routes', ['Closure /_test/three']);

        // When a route is called
        $this->get('_test/four');

        // When the test suite executes the method to gather the non-hit routes
        $routesUntested = RouteHelper::getUntestedRoutes();

        // Then the hit routes and excluded routes should not be collected into the untested routes array...
        $this->assertNotContains('Closure /_test/three GET', $routesUntested);
        $this->assertNotContains('Closure /_test/four GET', $routesUntested);

        // ...and only the non-hit and included routes should be collected into the untested routes array
        $this->assertContains('testing.one GET', $routesUntested);
        $this->assertContains('testing.two GET', $routesUntested);
    }

    public function test_it_generates_the_test_criteria_for_not_hit_routes_excluding_route_groups(): void
    {
        // Given some routes
        $this->setupTestingRoutes();

        // Given the config stating not to collect a route
        Config::set('route-coverage.exclude_route_groups', ['testing']);

        // When a route is called
        $this->get('_named_test/one');

        // When the test suite executes the method to gather the non-hit routes
        $routesUntested = RouteHelper::getUntestedRoutes();

        // Then the hit routes and excluded routes should not be collected into the untested routes array...
        $this->assertNotContains('testing.one GET', $routesUntested);
        $this->assertNotContains('testing.two GET', $routesUntested);

        // ...and only the non-hit and included routes should be collected into the untested routes array
        $this->assertContains('Closure /_test/three GET', $routesUntested);
        $this->assertContains('Closure /_test/four GET', $routesUntested);
    }

    public function test_the_test_will_pass_if_all_routes_are_tested_or_excluded(): void
    {
        // Given some routes
        $this->setupTestingRoutes();

        // Given the config stating not to collect a route
        Config::set('route-coverage.exclude_route_groups', ['testing']);

        // When a route is called
        $this->get('_test/three');
        $this->get('_test/four');

        // When the test suite executes the method to gather the non-hit routes
        $routesUntested = RouteHelper::getUntestedRoutes();

        // Then the mirrored test criteria for the publishable/tests/Feature/zRouteCoverageTest.php should pass
        $this->assertSame(0, count($routesUntested), "Missing feature tests for Routes:\n".implode("\n", $routesUntested));
    }
}
