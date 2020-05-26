# laravel-route-coverage-test
Confirms whether or not there exists a feature test for all routes in Laravel application

# Description

This is a slightly crude but seemingly effective way of checking which of your routes lack feature tests. It simple uses middleware to record all routes being hit during the feature tests, then runs a final test where it compares that array to an array of all routes.

To keep it simple, I have not attempted to use any sort of Laravel package discovery methods or the like - you'll want to simply copy these two files over and register the Middleware. 

# Install pre Laravel 5.5

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

# Install post Laravel 5.5

Nothing more required then:

```bash
composer require jrmadsen67/laravel-route-coverage-test --dev
```

and

```bash
php artisan vendor:publish --provider="jrmadsen67\LaravelRouteCoverageTest\Providers\CoverageServiceProvider
```


# Usage

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


## License

MIT License

Copyright (c) 2020 Jeff Madsen

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

