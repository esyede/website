<?php

namespace Esyede\LanguageBuilder;

defined('DS') or die('No direct script access.');

use System\Package;
use System\Storage;
use System\Str;

class Dir
{
    public static function create_missing($from, $to)
    {
        $files = static::read(path('app').'language/'.$from);

        foreach ($files as $file) {
            static::create(preg_replace('|([\/])'.$from.'([\/])|', "$1$to$2", $file));
        }

        $packages = static::packages($from);

        foreach ($packages as $package) {
            $files = static::read($package['path'].$from);

            foreach ($files as $file) {
                static::create(preg_replace('|([\/])'.$from.'([\/])|', "$1$to$2", $file));
            }
        }
    }

    public static function create($file)
    {
        $dir = str_replace(basename($file), '', $file);

        if (! is_dir($dir)) {
            static::make($dir);
        }

        if (! is_file($file)) {
            $data = "<?php\n\ndefined('DS') or die('No direct script access.');\n\nreturn [\n\n\t// ..\n\n];\n";
            Storage::put($file, $data);
        }

        return true;
    }

    public static function packages($lang = null)
    {
        $packages = $packages = Package::all();
        $folders = [];

        if ($packages) {
            foreach ($packages as $package) {
                if (is_dir(Package::path($package['location']).'/language/'.$lang)) {
                    $folders[] = [
                        'path' => Package::path($package['location']).'language/',
                        'name' => $package,
                    ];
                }
            }
        }

        return $folders;
    }

    public static function read($dir, array $ignore = [])
    {
        $files = scandir($dir);
        $items = [];

        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || ! Str::ends_with($file, '.php')) {
                continue;
            }

            if (! in_array($file, $ignore)) {
                $items[] = $dir.'/'.$file;
            }
        }

        return $items;
    }

    public static function make($dir, $permission = 0755, $nested = false)
    {
        $dir = str_replace(['../', './'], '', $dir);

        if (! mkdir($dir, $permission, $nested)) {
            Log::error(sprintf('transman: Failed to create the directory: %s', $dir));
            return false;
        }

        return true;
    }
}
