# laravel-js-routes-publish

This package allows you to run the jsroute:publish artisan command to generate a route file that can be used for front to back routing in JavaScript. Ment to be used with [laravel-js-routes](https://github.com/nonetallt/laravel-js-routes).

Tested with Laravel 5.5+

# Installation:

```
composer require nonetallt/jsroute --dev
```

# Usage:

```
php artisan jsroute:publish
```

# Configuration

Running the vendor:publish -command allows you to configure the package using the conf-file in config/jsroute.php.
```
php artisan vendor:publish --provider="Nonetallt\Jsroute\JsrouteServiceProvider"
```

More detailed documentation of option usage in config/jsroute.php
```php
<?php

return 
[
    // Determine where the output will be written
    'path' => resource_path('assets/js/routes.js'),

    // Define the groups you don't wish to publish
    'exclude_middleware' => ['api'],

    // Define the routes you don't wish to publish by name
    'exclude_by_name' => [],

    /* 
     * Sort options: priority, asc, desc 
     * priority: in order that the routes are written and will be checked 
     * uri: alphabetically by route uri
     * verb: alphabetically by http verb
     * name: alphabetically by route name
     */
    'sort_by' => 'priority',

    /*
     * Declare the sort order
     * asc: ascending (for example: start from a -> b -> etc)
     * desc: descending
     */
    'sort_order' => 'asc',

    /*
     * Determines what object the routes will be generated for.
     * It is recommended to assign the object to the window.
     * Example: window.Route = new LaravelJsRoutes();
     * In this example, the js_reference should be 'Route'.
     */
    'js_reference' => 'Route',
];
```

# Automatic publishing with gulp:

You can use [gulp](https://www.npmjs.com/package/gulp) or another task runner of your choice to run the publish command automatically whenever there are changes in the routes files.

Installing gulp
```
npm install gulp --save-dev
```

gulpfile.js
```javascript
var gulp = require('gulp');
var exec = require('child_process').exec;

gulp.task('publish-routes', function (cb) {
    exec('php artisan jsroute:publish', function(err, stdout, stderr) {
        console.log(stdout);
        console.log(stderr);
        cb(err);
    });
})

gulp.task('watch-routes', function() {
    gulp.watch([ 'routes/*.php'  ], ['publish-routes']);
})
```

Running the command:
```
gulp watch-routes
```
