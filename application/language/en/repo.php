<?php

defined('DS') or exit('No direct script access.');

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
        'head' => 'Package Repository',
        'text' => 'Download and share your package with other developers',
        'btn1' => 'How to Install?',
        'btn2' => 'Share a Package',
    ],
    'modal' => [
        'install' => [
            'text1' => 'Installing :pkg package:',
            'text2' => 'php rakit package:install :pkg',
            'text3' => 'Manual installation:',
            'text4' => '1. Download the :pkg package',
            'text5' => '2. Extract it to the :pkg folder',
            'text6' => '3. If the package has assets, copy the assets to :pkg',
        ],
        'share' => [
            'text1' => 'How to share a package:',
            'text2' => '1. Login to :vcs and edit the :json file to add your package data.',
            'text3' => '2. Send a pull request of changes you made.',
            'text4' => '3. Create a new thread in the :sub subforum and explain the details.',
            'text5' => 'Releasing a new version:',
            'text6' => '1. Repeat the steps "How to share a package" above.',
            'text7' => '2. Edit first post of your thread and add details of the new version.',
        ],
        'okay' => 'Okay, Got it!',
    ],
    'side' => [
        'cat' => 'Categories',
    ],
    'content' => [
        'all' => 'All',
        'compat' => 'Compatible:',
        'visit' => "Visit package's repository",
        'maintained' => 'This package is still being maintained',
        'unmaintained' => 'This package is unmaintained',
    ],
];
