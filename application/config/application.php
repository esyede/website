<?php

defined('DS') or exit('No direct script access.');

return [
    /*
    |--------------------------------------------------------------------------
    | URL Aplikasi
    |--------------------------------------------------------------------------
    |
    | URL yang digunakan untuk mengakses aplikasi anda, tanpa garis miring.
    | Tidak harus diisi. Jika tidak diisi, kami akan mencoba untuk menebaknya.
    |
    */

    'url' => 'https://rakit.esyede.my.id',

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    |
    | Jika anda ingin menyertakan "index.php" di URL, abaikan saja opsi ini.
    | Namun, jika anda menggunakan mod_rewrite untuk mempercantik URL,
    | cukup isi opsi ini dengan string kosong.
    |
    */

    'index' => '',

    /*
    |--------------------------------------------------------------------------
    | Character Encoding
    |--------------------------------------------------------------------------
    |
    | Character encoding default yang digunakan oleh aplikasi anda. Encoding ini
    | akan digunakan oleh kelas Str, HTML, Form, dan kelas lainnya yang perlu
    | mengetahui jenis encoding yang akan digunakan untuk aplikasi anda.
    |
    */

    'encoding' => 'UTF-8',

    /*
    |--------------------------------------------------------------------------
    | Bahasa
    |--------------------------------------------------------------------------
    |
    | Bahasa default aplikasi anda. Bahasa ini akan digunakan oleh kelas Lang
    | sebagai bahasa default untuk fitur alih-bahasa.
    |
    */

    'language' => 'id',

    /*
    |--------------------------------------------------------------------------
    | List Bahasa
    |--------------------------------------------------------------------------
    |
    | Bahasa ini mungkin juga didukung oleh aplikasi anda. Jika request URI
    | ke aplikasi anda diawali dengan salah satu value dari list dibawah ini,
    | bahasa default diatas akan otomatis disetel ke bahasa itu.
    |
    */

    'languages' => [],

    /*
    |--------------------------------------------------------------------------
    | Zona Waktu
    |--------------------------------------------------------------------------
    |
    | Zona waktu default aplikasi anda. Zona waktu akan digunakan saat rakit
    | membutuhkan tanggal, seperti saat menulis ke file log atau ketika anda
    | menggunakan library Date.
    |
    */

    'timezone' => 'Asia/Jakarta',

    /*
    |--------------------------------------------------------------------------
    | Download Chunk Size
    |--------------------------------------------------------------------------
    |
    | Berapa banyak ukuran (dalam Mega Bytes) dari setiap potongan file binari
    | yang harus dikirim ke browser saat anda mengirimkan file ke user.
    |
    | Opsi ini digunakan untuk Response::download().
    |
    */

    'chunk_size' => 4,

    /*
    |--------------------------------------------------------------------------
    | Composer Autoload
    |--------------------------------------------------------------------------
    |
    | Lokasi file autoload milik composer. Jika anda menggunakan composer di
    | aplikasi anda, atur opsi ini ke path dimana file "autoload.php" berada.
    |
    | Jika path tidak ditemukan, aplikasi anda akan tetap berjalan, namun,
    | library yang anda install via composer tidak akan dikenali oleh rakit.
    |
    */

    'composer_autoload' => path('base').'vendor/autoload.php',

    /*
    |--------------------------------------------------------------------------
    | Application Key
    |--------------------------------------------------------------------------
    |
    | Key ini digunakan oleh kelas Crypter dan Cookie untuk menghasilkan
    | string dan hash terenkripsi yang aman. Sangat penting bahwa key ini
    | harus dirahasiakan dan tidak boleh dibagikan kepada siapa pun.
    |
    | Isilah dengan 32 karakter acak dan jangan diubah-ubah lagi. Anda juga
    | dapat mengisinya secara otomatis via rakit console.
    |
    */

    'key' => 'IMcwASuX5KCnPPFaS03ANsvMoJJm1RyN',
];
