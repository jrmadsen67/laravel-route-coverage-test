<?php

if (!function_exists('tests_path')) {
    /**
     * Get the path to the tests folder.
     */
    function tests_path(string $path = ''): string
    {
        return app()->basePath('tests'.($path ? DIRECTORY_SEPARATOR.$path : $path));
    }
}
