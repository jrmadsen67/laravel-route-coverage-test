# Laravel Route Coverage

[![Tests](https://github.com/jrmadsen67/laravel-route-coverage-test/actions/workflows/tests.yml/badge.svg)](https://github.com/jrmadsen67/laravel-route-coverage-test/actions/workflows/tests.yml)
[![Style](https://github.com/jrmadsen67/laravel-route-coverage-test/actions/workflows/style.yml/badge.svg)](https://github.com/jrmadsen67/laravel-route-coverage-test/actions/workflows/style.yml)

Tests to ensure that all routes are covered by atleast one feature test.

This is a slightly crude but effective way of checking which of your routes lack feature tests. It simply uses middleware to record all routes being hit during the feature tests, checks to ensure that matches the full route amount.

The `zRouteCoverageTest` has a funny name for a reason - PHPUnit runs tests in alphabetical order. To most easily capture all the test coverage data _first_, keep it named to run last, and in your Feature directory. Also - the output relies on routes having names to give useful data. Happy Testing!

---

## Index

-   [Installation](#installation)
-   [Usage](#usage)
-   [Testing](#testing)
-   [Changelog](#changelog)

---

# Installation

Via Composer, you can run a `composer require` which will grab the latest version of this repo...

```sh
composer require --dev jrmadsen67/laravel-route-coverage-test
```

...and then...

```sh
php artisan vendor:publish --provider="jrmadsen67\LaravelRouteCoverageTest\Providers\CoverageServiceProvider"
```

...to publish the required config and feature test file into your app. The middleware is automatically applied globally by this packages service provider.

**Note:** See version tagged `1.1` for Laravel `<5.5` support.

---

## Installation - This Package Version vs. PHP & Laravel Versions

The following table describes which version of this packagae you will require for the given PHP & Laravel version.

| Package Version | PHP Version  | Laravel Version |
| --------------- | ------------ | --------------- |
| ^2.0            | ^7.4 \| ^8.0 | ^7.0 \| ^8.0    |
| ^1.0            | -            | -               |

---

# Usage

Run your tests as normal via phpunit, or the default Laravel test suite:

```sh
php artisan test

# OR

vendor/bin/phpunit
```

---

## Testing

There is a Docker container that is pre-built that contains an Alpine CLI release of PHP + PHPUnit + xdebug. This is setup to test the project and can be setup via the following:

```sh
composer build
```

This should trigger Docker Compose to build the image.

There are tests for all code written, in which can be run via:

```sh
# Using PHPUnit, with code coverage reporting, within the Docker container
composer test

# Using PHPUnit, with code coverage reporting, within the Docker container, specifying a direct test
composer test-filtered ItGeneratesSqlFromMigrations

# Using PHPUnit, with code coverage reporting, using local phpunit and xdebug
composer test-local

# Using PHPUnit, with code coverage reporting, using local phpunit and xdebug, specifying a direct test
composer test-local-filtered ItGeneratesSqlFromMigrations
```

In those tests, there are Feature tests for a production ready implementation of the package. There are also Unit tests for each class written for full coverage.

You can also easily open a shell in the testing container by using the command:

```sh
composer shell
```

---

## Changelog

Any and all project changes for releases should be documented below. Versioning follows the [SEMVER](https://semver.org/) standard.

---

### Version 2.0.0

Big project refactor, see the changelog sections for more info.

#### Added

-   Config support for defining excluded routes and route groups
-   Docker container for a fixed testing environment with code coverage support via XDebug
-   New global tests path helper `tests_path()` that will generate a fully qualified path to the tests directory
-   Various composer scripts to shortcut common testing and style fixing functionality
-   GitHub actions for automated testing and style fixes as a basic CI pipeline
-   Spatie Ray support for enhanced debugging
-   Testing of this packages functionality
-   Code coverage and getting the coverage to around ~95%
-   PHP-CS-Fixer for making the project style adhere to a fixed set of code standards
-   Binding the package to both PHP and Laravel version requirements for easy compatibility reference

#### Changed

-   Refactored shared methods between the middleware and test into a new `ReportHelper` object for testing purposes and centralising of reusable code
-   Refactored the package middleware to reside instead within the package and its namespace, again so it can be tested and also to not pollute the installed application
-   Renamed `xCoverageTest` to `zRouteCoverageTest` to better reflect what the test covers

#### Fixed

-   The middleware now applies itself globally using the latest method of doing so for Laravel versions `>5.5`

#### Removed

-   The package middleware is no longer published into the installed application and is instead held within the package and its namespace

---

### Version 1.1

Initial release. Pre-semver implementation.

#### Added

-   Everything

#### Changed

-   Everything

#### Fixed

-   Everything

#### Removed

-   Everything
