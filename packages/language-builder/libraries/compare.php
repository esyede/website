<?php

namespace Esyede\LanguageBuilder;

defined('DS') or die('No direct script access.');

class Compare
{
    public static function files($from, $to)
    {
        $files = [
            'app' => static::app($from, $to),
            'packages' => static::packages($from, $to),
        ];

        return $files;
    }

    protected static function app($from, $to)
    {
        $path = path('app').'language/';
        $from_files = Dir::read($path.$from);
        $translated = Dir::read($path.$to);

        foreach ($from_files as $key => $file) {
            $from_array = require $file;
            $to_array = is_file($translated[$key]) ? (require $translated[$key]) : [];
            $files['all'][] = [
                'location' => DEFAULT_PACKAGE,
                'name' => str_replace(path('app'), '', basename($translated[$key], '.php')),
            ];

            if (static::keys($from_array, $to_array)) {
                $files['missing'][] = [
                    'location' => DEFAULT_PACKAGE,
                    'name' => str_replace(path('app'), '', basename($translated[$key], '.php')),
                ];
            } else {
                if (static::values($to_array)) {
                    $files['missing'][] = [
                        'location' => DEFAULT_PACKAGE,
                        'name' => str_replace(path('app'), '', basename($translated[$key], '.php')),
                    ];
                }
            }
        }

        return $files;
    }

    protected static function packages($from, $to)
    {
        $from_files = Dir::packages($from);
        $files = [];

        foreach ($from_files as $package) {
            $package_files = Dir::read($package['path'].$from);

            foreach ($package_files as $key => $file) {
                $from_array = require $file;
                $to_file = str_replace($from, $to, $file);
                $to_array = is_file($to_file) ? require $to_file : [];

                $files['all'][] = [
                    'location' => $package['name'],
                    'name' => str_replace(path('package'), '', basename($to_file, '.php')),
                ];

                if (static::keys($from_array, $to_array)) {
                    $files['missing'][] = [
                        'location' => $package['name'],
                        'name' => str_replace(path('package'), '', basename($to_file, '.php')),
                    ];
                } else {
                    if (static::values($to_array)) {
                        $files['missing'][] = [
                            'location' => $package['name'],
                            'name' => str_replace(path('package'), '', basename($to_file, '.php')),
                        ];
                    }
                }
            }
        }

        return $files;
    }

    protected static function keys($from, $to)
    {
        $diff = array_diff_key((array) $from, (array) $to);
        return count($diff) > 0;
    }

    protected static function values($array)
    {
        $array = (array) $array;

        foreach ($array as $item) {
            if (is_array($item)) {
                return static::values($item);
            }

            if ($item === '') {
                return true;
            }
        }

        return false;
    }
}
