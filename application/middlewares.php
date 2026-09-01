<?php

defined('DS') or exit('No direct access.');

/*
|--------------------------------------------------------------------------
| Middleware
|--------------------------------------------------------------------------
|
| Middleware menyediakan cara untuk melampirkan fungsionalitas ke rute anda.
| Middleware bawaan 'before' dan 'after' akan dipanggil sebelum dan sesudah
| setiap request direspon.
|
*/

Route::middleware('csrf', function () {
    $except = Config::get('application.csrf_except', []);

    foreach ((array) $except as $pattern) {
        if (Str::is($pattern, URI::current())) {
            return;
        }
    }

    if (Request::forged()) {
        return Response::error(422);
    }
});

Route::middleware('auth', function () {
    if (Auth::guest()) {
        return Response::error(401);
    }
});

Route::middleware('throttle', function ($limit, $minutes) {
    if (Throttle::exceeded($limit, $minutes)) {
        return Throttle::error();
    }
});
