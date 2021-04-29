<?php

namespace Tests\Feature;

use jrmadsen67\LaravelRouteCoverageTest\Helpers\RouteHelper;
use Tests\TestCase;

/**
 * This test class needs to run LAST! PhpUnit will run them in alphabetical order;
 * this is the simplest way to do that.
 */
class zRouteCoverageTest extends TestCase
{
    public function test_check_all_routes_tested(): void
    {
        // This functionality is broken out into a helper class so it can be tested
        $routesUntested = RouteHelper::getUntestedRoutes();

        // If this line is changed, please reflect this change in tests/Feature/ItHasTheExpectedTestingCriteriaTest.php
        $this->assertSame(0, count($routesUntested), "Missing feature tests for Routes:\n".implode("\n", $routesUntested));
    }
}
