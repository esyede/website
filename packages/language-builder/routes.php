<?php

defined('DS') or die('No direct script access.');

Route::get('(:package)', 'language-builder::home@index');
Route::post('(:package)/build', 'language-builder::home@build');
Route::get('(:package)/edit', 'language-builder::home@edit');
Route::post('(:package)/update', 'language-builder::home@update');
