<?php

defined('DS') or exit('No direct script access.');

use System\Storage;
use System\Request;

class Stuff
{
    protected static $packages;
    protected static $mtime;
    protected static $json;

    public static function packages()
    {
        static::populate();

        return static::$packages;
    }

    public static function populate()
    {
        static::$json = static::$json ? static::$json : path('base').'repositories.json';
        static::$mtime = static::$mtime ? static::$mtime : Storage::modified(static::$json);
        static::$packages = static::$packages
            ? static::$packages
            : json_decode(Storage::get(static::$json), true);
    }

    public static function outdated()
    {
        return Storage::modified(static::$json) > static::$mtime;
    }

    public static function categorize($array, $criteria)
    {
        return array_reduce($array, function ($grouped, $item) use ($criteria) {
            $key = is_callable($criteria) ? $criteria($item) : $item[$criteria];

            if (! array_key_exists($key, $grouped)) {
                $grouped[$key] = [];
            }

            array_push($grouped[$key], $item);

            return $grouped;
        }, []);
    }

    public static function paging(array $data, $offset, $limit)
    {
        $start = ($offset - 1) * $limit;
        $end = $start + $limit;
        $total = count($data);

        if ($start < 0 || $total <= $start) {
            return [];
        } elseif ($total <= $end) {
            return array_slice($data, $start);
        }

        return array_slice($data, $start, $end - $start);
    }

    public static function currpage()
    {
        $query = Request::getQueryString();

        if (preg_match('/page=[0-9]+$/', $query)) {
            $page = explode('=', $query);
            $page = abs((int) end($page));

            return $page;
        }

        return 1;
    }
}
