# laravel-js-routes-publish

Ment to be used with [laravel-js-routes](https://github.com/nonetallt/laravel-js-routes)

Installation:
```
composer require nonetallt/jsroute --dev
```

Usage:
```
php artisan jsroute:publish
```

Publishing the configuration:
```
php artisan vendor:publish --provider="Nonetallt\Jsroute\JsrouteServiceProvider"
```

Using gulp to publish routes automatically whenever they are changed:

Installing gulp
```
npm install gulp --save-dev
```

gulpfile.js
```
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
