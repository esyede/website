<?php

defined('DS') or exit('No direct access.');

return [
    /*
    |--------------------------------------------------------------------------
    | Repository Language Lines
    |--------------------------------------------------------------------------
    |
    | Baris - baris bahasa berikut ini digunakan untuk halaman repositories
    |
    */

    'hero' => [
        'head' => 'Repositori Paket',
        'text' => 'Download dan bagikan paket anda bersama pengembang lain',
        'btn1' => 'Cara Install?',
        'btn2' => 'Bagikan Paket',
    ],
    'modal' => [
        'install' => [
            'text1' => 'Contoh instalasi paket :pkg:',
            'text2' => 'php rakit package:install :pkg',
            'text3' => 'Instalasi manual:',
            'text4' => '1. Unduh paket :pkg tersebut',
            'text5' => '2. Ekstrak ke folder :pkg',
            'text6' => '3. Jika paket tersebut memiliki aset, salin asetnya ke :pkg',
        ],
        'share' => [
            'text1' => 'Cara berbagi paket:',
            'text2' => '1. Login ke :vcs dan edit file :json untuk menambahkan data paket anda.',
            'text3' => '2. Kirim pull request berupa perubahan yang anda buat tersebut.',
            'text4' => '3. Buat thread baru di subforum :sub sesuai nama paket anda dan jelaskan detailnya.',
            'text5' => 'Jika rilis versi baru:',
            'text6' => '1. Ulangi langkah "Cara berbagi paket" diatas.',
            'text7' => '2. Edit postingan pertama di thread anda dan tambahkan detail versi baru anda.',
        ],
        'okay' => 'Oke, Mengerti!',
    ],
    'side' => [
        'cat' => 'Kategori',
    ],
    'content' => [
        'all' => 'Semua',
        'compat' => 'Kompatibel:',
        'visit' => "Kunjungi repositori paket",
        'maintained' => 'Paket ini masih di manintain',
        'unmaintained' => 'Paket ini sudah tidak di manintain',
    ],
];
