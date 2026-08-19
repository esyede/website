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
