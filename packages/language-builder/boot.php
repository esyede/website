<?php

defined('DS') or die('No direct script access.');

Autoloader::map([
    'Esyede\LanguageBuilder\Dir' => __DIR__.'/libraries/dir.php',
    'Esyede\LanguageBuilder\Compare' => __DIR__.'/libraries/compare.php',
    'Esyede\LanguageBuilder\Utilities' => __DIR__.'/libraries/utilities.php',
]);
