# laravel-route-coverage-test
Confirms whether or not there exists a feature test for all routes in Laravel application

# Description

This is a slightly crude but seemingly effective way of checking which of your routes lack feature tests. It simple uses middleware to record all routes being hit during the feature tests, then runs a final test where it compares that array to an array of all routes.

To keep it simple, I have not attempted to use any sort of Laravel package discovery methods or the like - you'll want to simply copy these two files over and register the Middleware. 

# Usage

Install package, When you have finished the process outlined below, this can be completely removed:
```
composer require jrmadsen67/laravel-route-coverage-test --dev
```

After pulling in the two files, move each to the corresponding directory in your Laravel application:
```
cp vendor/jrmadsen67/laravel-route-coverage-test/src/test/Feature/xCoverageTest.php tests/Feature/

cp vendor/jrmadsen67/laravel-route-coverage-test/src/app/Http/Middleware/CollectCodeCoverage.php  app/Http/Middleware/
```

On Http/Kernel.php, register `CollectCodeCoverage`. This middeware will only run for tests, so will not have any effect on your production application:
```
 protected $middleware = [
       ....
        Middleware\CollectCodeCoverage::class,
    ];
```

Run yout phpunit:
```
vendor/bin/phpunit
```


# VERY IMPORTANT NOTE THAT YOU PROBABLY WON'T READ

The `xCoverageTest` has a funny name for a reason - PhpUnit runs tests in alphabetical order. To most easily capture all the test coverage data *first*, keep it named to run last, and in your Feature directory.

Also - the output relies on routes having names to give useful data. But since you're all smart enough to be using named routes, that won't be an issue for you in any case.

Happy Testing!

----

I prefer you use the Issues section for problems, but if you do need to reach me you can do so at: https://twitter.com/codebyjeff
