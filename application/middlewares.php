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

Route::middleware('can', function ($ability, $model = null) {
    // 'can:create,Post' passes the class to its policy; 'can:admin' a plain ability.
    if (Gate::denies($ability, is_null($model) ? [] : [$model])) {
        return Response::error(403);
    }
});

Route::middleware('throttle', function ($limit, $minutes = 1) {
    // 'throttle:60,1' counts per route and client; 'throttle:api' runs the limiter
    // defined with Throttle::define('api', ...).
    return Throttle::attempt($limit, $minutes);
});

Route::middleware('signed', function ($relative = null) {
    // 'signed:relative' ignores the scheme and host, e.g. behind a proxy that changes them.
    if (! URL::has_valid_signature('relative' !== $relative)) {
        return Response::error(403);
    }
});
