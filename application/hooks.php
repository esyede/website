<?php

defined('DS') or exit('No direct access.');

/*
|--------------------------------------------------------------------------
| Hook Handlers
|--------------------------------------------------------------------------
|
| Hook adalah sistem event-listener milik rakit. Ia memberikan cara yang bagus
| untuk memecah keterkaitan resource dalam aplikasi anda, sehingga kelas,
| library ataupun plugin tidak akan tercampur dan mudah untuk diawasi.
| Daftarkan callback dengan Hook::listen() dan framework akan menjalankannya
| setiap kali event yang cocok dipicu.
|
*/

Hook::listen('404', function () {
    return Response::error(404);
});

// Scheduled events, run by 'php rakit schedule:run' from a cron entry that fires every minute:
// * * * * * cd /path/to/app && php rakit schedule:run >> /dev/null 2>&1
//
// Hook::listen('rakit.schedule', function () {
//     Schedule::command('job:runall')->every_minute()->without_overlapping();
//     Schedule::call(function () {
//         DB::table('password_resets')->where('created_at', '<', now()->subDays(1))->delete();
//     })->daily()->name('prune password resets');
// });
