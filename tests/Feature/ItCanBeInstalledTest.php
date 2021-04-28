<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ItCanBeInstalledTest extends TestCase
{
    public function providesPublishableFiles(): array
    {
        // A workaround for a quirk in the PHPUnit load order which run before any tests, including the setUp method,
        // which means that Laravel doesn't load prior to running this method, so let's create the application.
        $this->refreshApplication();

        return [
            'tests files' => [
                'tests',
                tests_path('Feature/zRouteCoverageTest.php'),
            ],
            'config files' => [
                'config',
                config_path('route-coverage.php'),
            ],
        ];
    }

    /**
     * @dataProvider providesPublishableFiles
     */
    public function test_the_package_service_provider_can_publish(string $type, string $path): void
    {
        // Make sure we're starting from a clean state
        if (File::exists($path)) {
            File::delete($path);
        }

        $this->assertFileDoesNotExist($path);

        // Given the user wants to publish the package data
        // When the publish command is run for a given tag (or all tags if omitted)
        Artisan::call('vendor:publish --provider="jrmadsen67\\\LaravelRouteCoverageTest\\\Providers\\\CoverageServiceProvider" --tag="'.$type.'"');

        // Then verify that the published item exists at the expected location
        $this->assertStringNotContainsStringIgnoringCase(
            'Unable to locate publishable resources.',
            Artisan::output(),
            "Package {$type} publish failed."
        );

        $this->assertFileExists($path);
    }
}
