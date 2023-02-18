<?php

defined('DS') or exit('No direct script access.');

use System\Storage;
use System\Request;

class Repo
{
    protected static $packages;
    protected static $mtime;
    protected static $json;

    public static function packages()
    {
        static::$json = static::$json ?: path('base').'repositories.json';
        static::$mtime = static::$mtime ?: Storage::modified(static::$json);
        static::$packages = static::$packages ?: json_decode(Storage::get(static::$json), true);

        return static::$packages;
    }

    public static function categorize($array, $criteria)
    {
        return array_reduce($array, function ($groups, $item) use ($criteria) {
            $key = is_callable($criteria) ? $criteria($item) : $item[$criteria];

            if (!array_key_exists($key, $groups)) {
                $groups[$key] = [];
            }

            array_push($groups[$key], $item);
            return $groups;
        }, []);
    }

    public static function paginate(array $data, $offset, $limit)
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

    public static function current()
    {
        $query = Request::getQueryString();

        if (false !== preg_match('/page=[0-9]+$/', $query)) {
            $page = explode('=', $query);
            return abs((int) end($page));
        }

        return 1;
    }
}
