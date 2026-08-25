<?php

defined('DS') or exit('No direct script access.');

class Repo
{
    /**
     * Cached packages.
     *
     * @var array
     */
    protected static $packages;

    /**
     * Cached modified time of the packages JSON file.
     *
     * @var int
     */
    protected static $mtime;

    /**
     * Path to the packages JSON file.
     *
     * @var string
     */
    protected static $json;

    public static function packages()
    {
        static::$json = static::$json ?: path('base').'repositories.json';
        static::$mtime = static::$mtime ?: Storage::modified(static::$json);
        static::$packages = static::$packages ?: json_decode(Storage::get(static::$json), true);

        return static::$packages;
    }

    /**
     * Categorize an array of items by a given criteria.
     *
     * @param array $array
     * @param mixed $criteria
     *
     * @return array
     */
    public static function categorize($array, $criteria)
    {
        return array_reduce($array, function ($groups, $item) use ($criteria) {
            $key = is_callable($criteria) ? $criteria($item) : $item[$criteria];

            if (! array_key_exists($key, $groups)) {
                $groups[$key] = [];
            }

            array_push($groups[$key], $item);
            return $groups;
        }, []);
    }

    /**
     * Search an array of items for a given query.
     *
     * @param array  $data
     * @param string $query
     *
     * @return array
     */
    public static function search(array $data, $query)
    {
        $query = trim((string) $query);

        if ('' === $query) {
            return $data;
        }

        $needle = Str::lower($query);

        return array_values(array_filter($data, function ($item) use ($needle) {
            $haystack = Str::lower($item['name'].' '.$item['description'].' '.$item['category']);
            return false !== strpos($haystack, $needle);
        }));
    }

    /**
     * Paginate an array of items.
     *
     * @param array $data
     * @param int   $offset
     * @param int   $limit
     *
     * @return array
     */
    public static function paginate(array $data, $offset, $limit)
    {
        $start = ($offset - 1) * $limit;
        $end = $start + $limit;
        $total = count($data);

        return ($start < 0 || $total <= $start)
            ? []
            : array_slice($data, $start, ($total <= $end) ? null : ($end - $start));
    }

    /**
     * Get the current page number from the request.
     *
     * @return int
     */
    public static function current()
    {
        $page = Request::foundation()->query->get('page');

        return (is_numeric($page) && (int) $page > 0) ? abs((int) $page) : 1;
    }
}
