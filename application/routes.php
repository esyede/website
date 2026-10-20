<?php

defined('DS') or exit('No direct access.');

/*
|--------------------------------------------------------------------------
| Route
|--------------------------------------------------------------------------
|
| Cukup beri tahu rakit kata kerja HTTP dan URI yang harus ditanggapi.
| Rakit juga mendukung RESTful routing yang sangat cocok untuk membangun
| aplikasi berskala besar maupun API sederhana.
|
*/

Route::get('/', 'home@index');
Route::get('download', 'home@download');
Route::get('repositories/(:any?)', 'home@repositories');
Route::get('sitemap.xml', 'home@sitemap');

// Health check for load balancers and uptime monitors: 200 while the application
// boots and routes, 503 during maintenance ('php rakit down').
Route::get('up', function () {
    return Response::make('OK', 200, ['Content-Type' => 'text/plain; charset=UTF-8', 'Cache-Control' => 'no-store']);
});
