<?php

namespace System;

class Collection implements \ArrayAccess, \Countable, \IteratorAggregate, \JsonSerializable
{
    use Macroable;

    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items = [];

    /**
     * The methods that can be proxied.
     *
     * @var array
     */
    protected static $proxies = [
        'average', 'avg', 'contains', 'each', 'every', 'filter', 'first',
        'flat_map', 'group_by', 'key_by', 'map', 'max', 'min', 'partition',
        'reject', 'some', 'sort_by', 'sort_by_desc', 'sum', 'unique',
    ];

    /**
     * Create a new collection.
     *
     * @param mixed $items
     *
     * @return void
     */
    public function __construct($items = [])
    {
        $this->items = $this->get_arrayable_items($items);
    }

    /**
     * Create a new collection instance if the value isn't one already.
     *
     * @param mixed $items
     *
     * @return static
     */
    public static function make($items = [])
    {
        return new static($items);
    }

    /**
     * Wrap the given value in a collection if applicable.
     *
     * @param mixed $value
     *
     * @return static
     */
    public static function wrap($value)
    {
        return ($value instanceof self) ? new static($value) : new static(Arr::wrap($value));
    }

    /**
     * Get the underlying items from the given collection if applicable.
     *
     * @param array|static $value
     *
     * @return array
     */
    public static function unwrap($value)
    {
        return ($value instanceof self) ? $value->all() : $value;
    }

    /**
     * Create a new collection by invoking the callback a given amount of times.
     *
     * @param int      $number
     * @param callable $callback
     *
     * @return static
     */
    public static function times($number, callable $callback = null)
    {
        if ($number < 1) {
            return new static;
        }

        if (is_null($callback)) {
            return new static(range(1, $number));
        }

        return (new static(range(1, $number)))->map($callback);
    }

    /**
     * Get all of the items in the collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Get the average value of a given key.
     *
     * @param callable|string|null $callback
     *
     * @return mixed
     */
    public function avg($callback = null)
    {
        $callback = $this->value_retriever($callback);
        $items = $this->map(function ($value) use ($callback) {
            return $callback($value);
        })->filter(function ($value) {
            return !is_null($value);
        });

        if ($count = $items->count()) {
            return $items->sum() / $count;
        }
    }

    /**
     * Alias for the "avg" method.
     *
     * @param callable|string|null $callback
     *
     * @return mixed
     */
    public function average($callback = null)
    {
        return $this->avg($callback);
    }

    /**
     * Get the median of a given key.
     *
     * @param string|array|null $key
     *
     * @return mixed
     */
    public function median($key = null)
    {
        $values = (isset($key) ? $this->pluck($key) : $this)->filter(function ($item) {
            return !is_null($item);
        })->sort()->values();
        $count = $values->count();

        if ($count === 0) {
            return;
        }

        $middle = (int) ($count / 2);

        if ($count % 2) {
            return $values->get($middle);
        }

        return (new static([$values->get($middle - 1), $values->get($middle)]))->average();
    }

    /**
     * Get the mode of a given key.
     *
     * @param string|array|null $key
     *
     * @return array|null
     */
    public function mode($key = null)
    {
        if ($this->count() === 0) {
            return;
        }

        $collection = isset($key) ? $this->pluck($key) : $this;
        $counts = new self;
        $collection->each(function ($value) use ($counts) {
            $counts[$value] = isset($counts[$value]) ? $counts[$value] + 1 : 1;
        });

        $sorted = $counts->sort();
        $highest = $sorted->last();

        return $sorted->filter(function ($value) use ($highest) {
            return $value == $highest;
        })->sort()->keys()->all();
    }

    /**
     * Collapse the collection of items into a single array.
     *
     * @return static
     */
    public function collapse()
    {
        return new static(Arr::collapse($this->items));
    }

    /**
     * Alias for the "contains" method.
     *
     * @param mixed $key
     * @param mixed $operator
     * @param mixed $value
     *
     * @return bool
     */
    public function some($key, $operator = null, $value = null)
    {
        return call_user_func_array([$this, 'contains'], func_get_args());
    }

    /**
     * Determine if an item exists in the collection.
     *
     * @param mixed $key
     * @param mixed $operator
     * @param mixed $value
     *
     * @return bool
     */
    public function contains($key, $operator = null, $value = null)
    {
        if (func_num_args() === 1) {
            if ($this->use_as_callable($key)) {
                $placeholder = new \stdClass;
                return $this->first($key, $placeholder) !== $placeholder;
            }

            return in_array($key, $this->items);
        }

        $args = func_get_args();
        return $this->contains(call_user_func_array([$this, 'operator_for_where'], $args));
    }

    /**
     * Determine if an item exists in the collection using strict comparison.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return bool
     */
    public function contains_strict($key, $value = null)
    {
        if (func_num_args() === 2) {
            return $this->contains(function ($item) use ($key, $value) {
                return data_get($item, $key) === $value;
            });
        }

        if ($this->use_as_callable($key)) {
            return !is_null($this->first($key));
        }

        return in_array($key, $this->items, true);
    }

    /**
     * Cross join with the given lists, returning all possible permutations.
     *
     * @param mixed ...$lists
     *
     * @return static
     */
    public function cross_join(/* ...$lists */)
    {
        $lists = func_get_args();
        $mapped = array_map([$this, 'get_arrayable_items'], $lists);
        array_unshift($mapped, $this->items);

        return new static(call_user_func_array('Arr::cross_join', $mapped));
    }

    /**
     * Dump the collection and end the script.
     *
     * @param mixed ...$args
     *
     * @return void
     */
    public function dd(/* ...$args */)
    {
        call_user_func_array([$this, 'dump'], func_get_args());
        die(1);
    }

    /**
     * Dump the collection.
     *
     * @return $this
     */
    public function dump(/* ...$args */)
    {
        (new static(func_get_args()))->push($this)->each(function ($item) {
            \System\Foundation\Oops\Debugger::dump($item);
        });

        return $this;
    }

    /**
     * Get the items in the collection that are not present in the given items.
     *
     * @param mixed $items
     *
     * @return static
     */
    public function diff($items)
    {
        return new static(array_diff($this->items, $this->get_arrayable_items($items)));
    }

    /**
     * Get the items in the collection that are not present in the given items.
     *
     * @param mixed    $items
     * @param callable $callback
     *
     * @return static
     */
    public function diff_using($items, callable $callback)
    {
        return new static(array_udiff($this->items, $this->get_arrayable_items($items), $callback));
    }

    /**
     * Get the items in the collection whose keys and values are not present in the given items.
     *
     * @param mixed $items
     *
     * @return static
     */
    public function diff_assoc($items)
    {
        return new static(array_diff_assoc($this->items, $this->get_arrayable_items($items)));
    }

    /**
     * Get the items in the collection whose keys and values are not present in the given items.
     *
     * @param mixed    $items
     * @param callable $callback
     *
     * @return static
     */
    public function diff_assoc_using($items, callable $callback)
    {
        return new static(array_diff_uassoc($this->items, $this->get_arrayable_items($items), $callback));
    }

    /**
     * Get the items in the collection whose keys are not present in the given items.
     *
     * @param mixed $items
     *
     * @return static
     */
    public function diff_keys($items)
    {
        return new static(array_diff_key($this->items, $this->get_arrayable_items($items)));
    }

    /**
     * Get the items in the collection whose keys are not present in the given items.
     *
     * @param mixed    $items
     * @param callable $callback
     *
     * @return static
     */
    public function diff_keys_using($items, callable $callback)
    {
        return new static(array_diff_ukey($this->items, $this->get_arrayable_items($items), $callback));
    }

    /**
     * Retrieve duplicate items from the collection.
     *
     * @param callable|null $callback
     * @param bool          $strict
     *
     * @return static
     */
    public function duplicates($callback = null, $strict = false)
    {
        $items = $this->map($this->value_retriever($callback));
        $uniques = $items->unique(null, $strict);
        $compare = $this->duplicate_comparator($strict);
        $duplicates = new static;

        foreach ($items as $key => $value) {
            if ($uniques->is_not_empty() && $compare($value, $uniques->first())) {
                $uniques->shift();
            } else {
                $duplicates[$key] = $value;
            }
        }

        return $duplicates;
    }

    /**
     * Retrieve duplicate items from the collection using strict comparison.
     *
     * @param callable|null $callback
     *
     * @return static
     */
    public function duplicates_strict($callback = null)
    {
        return $this->duplicates($callback, true);
    }

    /**
     * Get the comparison function to detect duplicates.
     *
     * @param bool $strict
     *
     * @return \Closure
     */
    protected function duplicate_comparator($strict)
    {
        return function ($a, $b) use ($strict) {
            return $strict ? ($a === $b) : ($a == $b);
        };
    }

    /**
     * Execute a callback over each item.
     *
     * @param callable $callback
     *
     * @return $this
     */
    public function each(callable $callback)
    {
        foreach ($this->items as $key => $item) {
            if ($callback($item, $key) === false) {
                break;
            }
        }

        return $this;
    }

    /**
     * Execute a callback over each nested chunk of items.
     *
     * @param callable $callback
     *
     * @return static
     */
    public function each_spread(callable $callback)
    {
        return $this->each(function ($chunk, $key) use ($callback) {
            $chunk[] = $key;
            return call_user_func_array($callback, $chunk);
        });
    }

    /**
     * Determine if all items in the collection pass the given test.
     *
     * @param string|callable $key
     * @param mixed           $operator
     * @param mixed           $value
     *
     * @return bool
     */
    public function every($key, $operator = null, $value = null)
    {
        if (func_num_args() === 1) {
            $callback = $this->value_retriever($key);

            foreach ($this->items as $k => $v) {
                if (!$callback($v, $k)) {
                    return false;
                }
            }

            return true;
        }

        $args = func_get_args();
        return $this->every(call_user_func_array([$this, 'operator_for_where'], $args));
    }

    /**
     * Get all items except for those with the specified keys.
     *
     * @param Collection|mixed $keys
     *
     * @return static
     */
    public function except($keys)
    {
        if ($keys instanceof self) {
            $keys = $keys->all();
        } elseif (!is_array($keys)) {
            $keys = func_get_args();
        }

        return new static(Arr::except($this->items, $keys));
    }

    /**
     * Run a filter over each of the items.
     *
     * @param callable|null $callback
     *
     * @return static
     */
    public function filter(callable $callback = null)
    {
        return new static($callback ? Arr::where($this->items, $callback) : array_filter($this->items));
    }

    /**
     * Apply the callback if the value is truthy.
     *
     * @param bool     $value
     * @param callable $callback
     * @param callable $default
     *
     * @return static|mixed
     */
    public function when($value, callable $callback, callable $default = null)
    {
        if ($value) {
            return $callback($this, $value);
        } elseif ($default) {
            return $default($this, $value);
        }

        return $this;
    }

    /**
     * Apply the callback if the collection is empty.
     *
     * @param callable $callback
     * @param callable $default
     *
     * @return static|mixed
     */
    public function when_empty(callable $callback, callable $default = null)
    {
        return $this->when($this->is_empty(), $callback, $default);
    }

    /**
     * Apply the callback if the collection is not empty.
     *
     * @param callable $callback
     * @param callable $default
     *
     * @return static|mixed
     */
    public function when_not_empty(callable $callback, callable $default = null)
    {
        return $this->when($this->is_not_empty(), $callback, $default);
    }

    /**
     * Apply the callback if the value is falsy.
     *
     * @param bool     $value
     * @param callable $callback
     * @param callable $default
     *
     * @return static|mixed
     */
    public function unless($value, callable $callback, callable $default = null)
    {
        return $this->when(!$value, $callback, $default);
    }

    /**
     * Apply the callback unless the collection is empty.
     *
     * @param callable $callback
     * @param callable $default
     *
     * @return static|mixed
     */
    public function unless_empty(callable $callback, callable $default = null)
    {
        return $this->when_not_empty($callback, $default);
    }

    /**
     * Apply the callback unless the collection is not empty.
     *
     * @param callable $callback
     * @param callable $default
     *
     * @return static|mixed
     */
    public function unless_not_empty(callable $callback, callable $default = null)
    {
        return $this->when_empty($callback, $default);
    }

    /**
     * Filter items by the given key value pair.
     *
     * @param string $key
     * @param mixed  $operator
     * @param mixed  $value
     *
     * @return static
     */
    public function where($key, $operator = null, $value = null)
    {
        $args = func_get_args();
        return $this->filter(call_user_func_array(array($this, 'operator_for_where'), $args));
    }

    /**
     * Get an operator checker callback.
     *
     * @param string $key
     * @param string $operator
     * @param mixed  $value
     *
     * @return \Closure
     */
    protected function operator_for_where($key, $operator = null, $value = null)
    {
        if (func_num_args() === 1) {
            $value = true;
            $operator = '=';
        }

        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        return function ($item) use ($key, $operator, $value) {
            $retrieved = data_get($item, $key);
            $strings = array_filter([$retrieved, $value], function ($value) {
                return is_string($value) || (is_object($value) && method_exists($value, '__toString'));
            });

            if (count($strings) < 2 && count(array_filter([$retrieved, $value], 'is_object')) == 1) {
                return in_array($operator, ['!=', '<>', '!==']);
            }

            switch ($operator) {
                default:
                case '=':
                case '==':  return $retrieved == $value;
                case '!=':
                case '<>':  return $retrieved != $value;
                case '<':   return $retrieved < $value;
                case '>':   return $retrieved > $value;
                case '<=':  return $retrieved <= $value;
                case '>=':  return $retrieved >= $value;
                case '===': return $retrieved === $value;
                case '!==': return $retrieved !== $value;
            }
        };
    }

    /**
     * Filter items by the given key value pair using strict comparison.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return static
     */
    public function where_strict($key, $value)
    {
        return $this->where($key, '===', $value);
    }

    /**
     * Filter items by the given key value pair.
     *
     * @param string $key
     * @param mixed  $values
     * @param bool   $strict
     *
     * @return static
     */
    public function where_in($key, $values, $strict = false)
    {
        $values = $this->get_arrayable_items($values);
        return $this->filter(function ($item) use ($key, $values, $strict) {
            return in_array(data_get($item, $key), $values, $strict);
        });
    }

    /**
     * Filter items by the given key value pair using strict comparison.
     *
     * @param string $key
     * @param mixed  $values
     *
     * @return static
     */
    public function where_in_strict($key, $values)
    {
        return $this->where_in($key, $values, true);
    }

    /**
     * Filter items such that the value of the given key is between the given values.
     *
     * @param string $key
     * @param array  $values
     *
     * @return static
     */
    public function where_between($key, $values)
    {
        return $this->where($key, '>=', reset($values))->where($key, '<=', end($values));
    }

    /**
     * Filter items such that the value of the given key is not between the given values.
     *
     * @param string  $key
     * @param array   $values
     *
     * @return static
     */
    public function where_not_between($key, $values)
    {
        return $this->filter(function ($item) use ($key, $values) {
            return data_get($item, $key) < reset($values) || data_get($item, $key) > end($values);
        });
    }

    /**
     * Filter items by the given key value pair.
     *
     * @param string $key
     * @param mixed  $values
     * @param bool   $strict
     *
     * @return static
     */
    public function where_not_in($key, $values, $strict = false)
    {
        $values = $this->get_arrayable_items($values);
        return $this->reject(function ($item) use ($key, $values, $strict) {
            return in_array(data_get($item, $key), $values, $strict);
        });
    }

    /**
     * Filter items by the given key value pair using strict comparison.
     *
     * @param string $key
     * @param mixed  $values
     *
     * @return static
     */
    public function where_not_in_strict($key, $values)
    {
        return $this->where_not_in($key, $values, true);
    }

    /**
     * Filter the items, removing any items that don't match the given type.
     *
     * @param string $type
     *
     * @return static
     */
    public function where_instance_of($type)
    {
        return $this->filter(function ($value) use ($type) {
            return ($value instanceof $type);
        });
    }

    /**
     * Get the first item from the collection passing the given truth test.
     *
     * @param callable|null $callback
     * @param mixed $default
     *
     * @return mixed
     */
    public function first(callable $callback = null, $default = null)
    {
        return Arr::first($this->items, $callback, $default);
    }

    /**
     * Get the first item by the given key value pair.
     *
     * @param string $key
     * @param mixed  $operator
     * @param mixed  $value
     *
     * @return mixed
     */
    public function first_where($key, $operator = null, $value = null)
    {
        $args = func_get_args();
        return $this->first(call_user_func_array([$this, 'operator_for_where'], $args));
    }

    /**
     * Get a flattened array of the items in the collection.
     *
     * @param int $depth
     *
     * @return static
     */
    public function flatten($depth = INF)
    {
        return new static(Arr::flatten($this->items, $depth));
    }

    /**
     * Flip the items in the collection.
     *
     * @return static
     */
    public function flip()
    {
        return new static(array_flip($this->items));
    }

    /**
     * Remove an item from the collection by key.
     *
     * @param string|array $keys
     *
     * @return $this
     */
    public function forget($keys)
    {
        foreach ((array) $keys as $key) {
            $this->offsetUnset($key);
        }

        return $this;
    }

    /**
     * Get an item from the collection by key.
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if ($this->offsetExists($key)) {
            return $this->items[$key];
        }

        return value($default);
    }

    /**
     * Group an associative array by a field or using a callback.
     *
     * @param array|callable|string $group_by
     * @param bool                  $preserve_keys
     *
     * @return static
     */
    public function group_by($group_by, $preserve_keys = false)
    {
        if (is_array($group_by)) {
            $gnext = $group_by;
            $group_by = array_shift($gnext);
        }

        $group_by = $this->value_retriever($group_by);
        $results = [];

        foreach ($this->items as $key => $value) {
            $gkeys = $group_by($value, $key);
            $gkeys = is_array($gkeys) ? $gkeys : [$gkeys];

            foreach ($gkeys as $gkey) {
                $gkey = is_bool($gkey) ? (int) $gkey : $gkey;
                if (!array_key_exists($gkey, $results)) {
                    $results[$gkey] = new static;
                }

                $results[$gkey]->offsetSet($preserve_keys ? $key : null, $value);
            }
        }

        $result = new static($results);
        return empty($gnext) ? $result : $result->map->group_by($gnext, $preserve_keys);
    }

    /**
     * Key an associative array by a field or using a callback.
     *
     * @param callable|string $key_by
     *
     * @return static
     */
    public function key_by($key_by)
    {
        $key_by = $this->value_retriever($key_by);
        $results = [];

        foreach ($this->items as $key => $item) {
            $resolved = $key_by($item, $key);

            if (is_object($resolved)) {
                $resolved = (string) $resolved;
            }

            $results[$resolved] = $item;
        }

        return new static($results);
    }

    /**
     * Determine if an item exists in the collection by key.
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function has($key)
    {
        $keys = is_array($key) ? $key : func_get_args();

        foreach ($keys as $value) {
            if (!$this->offsetExists($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Concatenate values of a given key as a string.
     *
     * @param string $value
     * @param string $glue
     *
     * @return string
     */
    public function implode($value, $glue = null)
    {
        $first = $this->first();

        if (is_array($first) || is_object($first)) {
            return implode($glue, $this->pluck($value)->all());
        }

        return implode($value, $this->items);
    }

    /**
     * Intersect the collection with the given items.
     *
     * @param mixed $items
     *
     * @return static
     */
    public function intersect($items)
    {
        return new static(array_intersect($this->items, $this->get_arrayable_items($items)));
    }

    /**
     * Intersect the collection with the given items by key.
     *
     * @param mixed $items
     *
     * @return static
     */
    public function intersect_by_keys($items)
    {
        return new static(array_intersect_key(
            $this->items, $this->get_arrayable_items($items)
        ));
    }

    /**
     * Determine if the collection is empty or not.
     *
     * @return bool
     */
    public function is_empty()
    {
        return empty($this->items);
    }

    /**
     * Determine if the collection is not empty.
     *
     * @return bool
     */
    public function is_not_empty()
    {
        return !$this->is_empty();
    }

    /**
     * Determine if the given value is callable, but not a string.
     *
     * @param mixed $value
     *
     * @return bool
     */
    protected function use_as_callable($value)
    {
        return !is_string($value) && is_callable($value);
    }

    /**
     * Join all items from the collection using a string. The final items can use a separate glue string.
     *
     * @param string $glue
     * @param string $final_glue
     *
     * @return string
     */
    public function join($glue, $final_glue = '')
    {
        if ($final_glue === '') {
            return $this->implode($glue);
        }

        $count = $this->count();

        if ($count === 0) {
            return '';
        }

        if ($count === 1) {
            return $this->last();
        }

        $collection = new static($this->items);
        $last = $collection->pop();

        return $collection->implode($glue) . $final_glue . $last;
    }

    /**
     * Get the keys of the collection items.
     *
     * @return static
     */
    public function keys()
    {
        return new static(array_keys($this->items));
    }

    /**
     * Get the last item from the collection.
     *
     * @param callable|null $callback
     * @param mixed         $default
     *
     * @return mixed
     */
    public function last(callable $callback = null, $default = null)
    {
        return Arr::last($this->items, $callback, $default);
    }

    /**
     * Get the values of a given key.
     *
     * @param string|array $value
     * @param string|null  $key
     *
     * @return static
     */
    public function pluck($value, $key = null)
    {
        return new static(Arr::pluck($this->items, $value, $key));
    }

    /**
     * Run a map over each of the items.
     *
     * @param callable $callback
     *
     * @return static
     */
    public function map(callable $callback)
    {
        $keys = array_keys($this->items);
        $items = array_map($callback, $this->items, $keys);

        return new static(array_combine($keys, $items));
    }

    /**
     * Run a map over each nested chunk of items.
     *
     * @param callable $callback
     *
     * @return static
     */
    public function map_spread(callable $callback)
    {
        return $this->map(function ($chunk, $key) use ($callback) {
            $chunk[] = $key;
            return call_user_func_array($callback, $chunk);
        });
    }

    /**
     * Run a dictionary map over the items.
     *
     * The callback should return an associative array with a single key/value pair.
     *
     * @param callable $callback
     *
     * @return static
     */
    public function map_to_dictionary(callable $callback)
    {
        $dictionary = [];

        foreach ($this->items as $key => $item) {
            $pair = $callback($item, $key);
            $key = key($pair);
            $value = reset($pair);

            if (!isset($dictionary[$key])) {
                $dictionary[$key] = [];
            }

            $dictionary[$key][] = $value;
        }

        return new static($dictionary);
    }

    /**
     * Run a grouping map over the items.
     *
     * The callback should return an associative array with a single key/value pair.
     *
     * @param callable  $callback
     * @return static
     */
    public function map_to_groups(callable $callback)
    {
        return $this->map_to_dictionary($callback)->map([$this, 'make']);
    }

    /**
     * Run an associative map over each of the items.
     *
     * The callback should return an associative array with a single key/value pair.
     *
     * @param callable $callback
     *
     * @return static
     */
    public function map_with_keys(callable $callback)
    {
        $result = [];

        foreach ($this->items as $key => $value) {
            $assoc = $callback($value, $key);

            foreach ($assoc as $mapKey => $mapValue) {
                $result[$mapKey] = $mapValue;
            }
        }

        return new static($result);
    }

    /**
     * Map a collection and flatten the result by a single level.
     *
     * @param callable $callback
     *
     * @return static
     */
    public function flat_map(callable $callback)
    {
        return $this->map($callback)->collapse();
    }

    /**
     * Map the values into a new class.
     *
     * @param string $class
     *
     * @return static
     */
    public function map_into($class)
    {
        return $this->map(function ($value, $key) use ($class) {
            return new $class($value, $key);
        });
    }

    /**
     * Get the max value of a given key.
     *
     * @param callable|string|null $callback
     *
     * @return mixed
     */
    public function max($callback = null)
    {
        $callback = $this->value_retriever($callback);
        return $this->filter(function ($value) {
            return !is_null($value);
        })->reduce(function ($result, $item) use ($callback) {
            $value = $callback($item);
            return is_null($result) || $value > $result ? $value : $result;
        });
    }

    /**
     * Merge the collection with the given items.
     *
     * @param mixed $items
     *
     * @return static
     */
    public function merge($items)
    {
        return new static(array_merge($this->items, $this->get_arrayable_items($items)));
    }

    /**
     * Recursively merge the collection with the given items.
     *
     * @param mixed $items
     *
     * @return static
     */
    public function merge_recursive($items)
    {
        return new static(array_merge_recursive($this->items, $this->get_arrayable_items($items)));
    }

    /**
     * Create a collection by using this collection for keys and another for its values.
     *
     * @param mixed $values
     *
     * @return static
     */
    public function combine($values)
    {
        return new static(array_combine($this->all(), $this->get_arrayable_items($values)));
    }

    /**
     * Union the collection with the given items.
     *
     * @param mixed $items
     *
     * @return static
     */
    public function union($items)
    {
        return new static($this->items + $this->get_arrayable_items($items));
    }

    /**
     * Get the min value of a given key.
     *
     * @param callable|string|null $callback
     *
     * @return mixed
     */
    public function min($callback = null)
    {
        $callback = $this->value_retriever($callback);
        return $this->map(function ($value) use ($callback) {
            return $callback($value);
        })->filter(function ($value) {
            return !is_null($value);
        })->reduce(function ($result, $value) {
            return (is_null($result) || $value < $result) ? $value : $result;
        });
    }

    /**
     * Create a new collection consisting of every n-th element.
     *
     * @param int $step
     * @param int $offset
     *
     * @return static
     */
    public function nth($step, $offset = 0)
    {
        $new = [];
        $position = 0;

        foreach ($this->items as $item) {
            if ($position % $step === $offset) {
                $new[] = $item;
            }

            $position++;
        }

        return new static($new);
    }

    /**
     * Get the items with the specified keys.
     *
     * @param mixed $keys
     *
     * @return static
     */
    public function only($keys)
    {
        if (is_null($keys)) {
            return new static($this->items);
        }

        if ($keys instanceof self) {
            $keys = $keys->all();
        }

        $keys = is_array($keys) ? $keys : func_get_args();
        return new static(Arr::only($this->items, $keys));
    }

    /**
     * "Paginate" the collection by slicing it into a smaller collection.
     *
     * @param int $page
     * @param int $per_page
     *
     * @return static
     */
    public function for_page($page, $per_page)
    {
        $offset = max(0, ($page - 1) * $per_page);
        return $this->slice($offset, $per_page);
    }

    /**
     * Partition the collection into two arrays using the given callback or key.
     *
     * @param callable|string $key
     * @param mixed           $operator
     * @param mixed           $value
     *
     * @return static
     */
    public function partition($key, $operator = null, $value = null)
    {
        $partitions = array(new static(), new static());

        if (func_num_args() === 1) {
            $callback = $this->value_retriever($key);
        } else {
            $args = func_get_args();
            $callback = call_user_func_array([$this, 'operator_for_where'], $args);
        }

        foreach ($this->items as $key => $item) {
            $partitions[(int) !$callback($item, $key)][$key] = $item;
        }

        return new static($partitions);
    }

    /**
     * Pass the collection to the given callback and return the result.
     *
     * @param callable $callback
     *
     * @return mixed
     */
    public function pipe(callable $callback)
    {
        return $callback($this);
    }

    /**
     * Get and remove the last item from the collection.
     *
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->items);
    }

    /**
     * Push an item onto the beginning of the collection.
     *
     * @param mixed $value
     * @param mixed $key
     *
     * @return $this
     */
    public function prepend($value, $key = null)
    {
        $this->items = Arr::prepend($this->items, $value, $key);
        return $this;
    }

    /**
     * Push an item onto the end of the collection.
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function push($value)
    {
        $this->offsetSet(null, $value);
        return $this;
    }

    /**
     * Push all of the given items onto the collection.
     *
     * @param iterable $source
     *
     * @return static
     */
    public function concat($source)
    {
        $result = new static($this);

        foreach ($source as $item) {
            $result->push($item);
        }

        return $result;
    }

    /**
     * Get and remove an item from the collection.
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function pull($key, $default = null)
    {
        return Arr::pull($this->items, $key, $default);
    }

    /**
     * Put an item in the collection by key.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return $this
     */
    public function put($key, $value)
    {
        $this->offsetSet($key, $value);
        return $this;
    }

    /**
     * Get one or a specified number of items randomly from the collection.
     *
     * @param int|null $number
     *
     * @return static|mixed
     */
    public function random($number = null)
    {
        if (is_null($number)) {
            return Arr::random($this->items);
        }

        return new static(Arr::random($this->items, $number));
    }

    /**
     * Reduce the collection to a single value.
     *
     * @param callable $callback
     * @param mixed    $initial
     *
     * @return mixed
     */
    public function reduce(callable $callback, $initial = null)
    {
        return array_reduce($this->items, $callback, $initial);
    }

    /**
     * Create a collection of all elements that do not pass a given truth test.
     *
     * @param callable|mixed $callback
     *
     * @return static
     */
    public function reject($callback = true)
    {
        $use_as_callable = $this->use_as_callable($callback);
        return $this->filter(function ($value, $key) use ($callback, $use_as_callable) {
            return $use_as_callable ? !$callback($value, $key) : $value != $callback;
        });
    }

    /**
     * Replace the collection items with the given items.
     *
     * @param mixed $items
     *
     * @return static
     */
    public function replace($items)
    {
        return new static(array_replace($this->items, $this->get_arrayable_items($items)));
    }

    /**
     * Recursively replace the collection items with the given items.
     *
     * @param mixed $items
     *
     * @return static
     */
    public function replace_recursive($items)
    {
        return new static(array_replace_recursive($this->items, $this->get_arrayable_items($items)));
    }

    /**
     * Reverse items order.
     *
     * @return static
     */
    public function reverse()
    {
        return new static(array_reverse($this->items, true));
    }

    /**
     * Search the collection for a given value and return the corresponding key if successful.
     *
     * @param mixed $value
     * @param bool  $strict
     *
     * @return mixed
     */
    public function search($value, $strict = false)
    {
        if (!$this->use_as_callable($value)) {
            return array_search($value, $this->items, $strict);
        }

        foreach ($this->items as $key => $item) {
            if (call_user_func($value, $item, $key)) {
                return $key;
            }
        }

        return false;
    }

    /**
     * Get and remove the first item from the collection.
     *
     * @return mixed
     */
    public function shift()
    {
        return array_shift($this->items);
    }

    /**
     * Shuffle the items in the collection.
     *
     * @param int $seed
     *
     * @return static
     */
    public function shuffle($seed = null)
    {
        return new static(Arr::shuffle($this->items, $seed));
    }

    /**
     * Slice the underlying collection array.
     *
     * @param int $offset
     * @param int $length
     *
     * @return static
     */
    public function slice($offset, $length = null)
    {
        return new static(array_slice($this->items, $offset, $length, true));
    }

    /**
     * Split a collection into a certain number of groups.
     *
     * @param int $number_of_groups
     *
     * @return static
     */
    public function split($number_of_groups)
    {
        if ($this->is_empty()) {
            return new static;
        }

        $groups = new static;
        $gsize = floor($this->count() / $number_of_groups);
        $remain = $this->count() % $number_of_groups;
        $start = 0;

        for ($i = 0; $i < $number_of_groups; $i++) {
            $size = $gsize;

            if ($i < $remain) {
                $size++;
            }

            if ($size) {
                $groups->push(new static(array_slice($this->items, $start, $size)));
                $start += $size;
            }
        }

        return $groups;
    }

    /**
     * Chunk the underlying collection array.
     *
     * @param int $size
     *
     * @return static
     */
    public function chunk($size)
    {
        if ($size <= 0) {
            return new static;
        }

        $chunks = [];

        foreach (array_chunk($this->items, $size, true) as $chunk) {
            $chunks[] = new static($chunk);
        }

        return new static($chunks);
    }

    /**
     * Sort through each item with a callback.
     *
     * @param callable|null $callback
     *
     * @return static
     */
    public function sort(callable $callback = null)
    {
        $items = $this->items;
        $callback ? uasort($items, $callback) : asort($items);

        return new static($items);
    }

    /**
     * Sort the collection using the given callback.
     *
     * @param callable|string $callback
     * @param int             $options
     * @param bool            $descending
     *
     * @return static
     */
    public function sort_by($callback, $options = SORT_REGULAR, $descending = false)
    {
        $results = [];
        $callback = $this->value_retriever($callback);

        foreach ($this->items as $key => $value) {
            $results[$key] = $callback($value, $key);
        }

        $descending ? arsort($results, $options) : asort($results, $options);

        foreach (array_keys($results) as $key) {
            $results[$key] = $this->items[$key];
        }

        return new static($results);
    }

    /**
     * Sort the collection in descending order using the given callback.
     *
     * @param callable|string $callback
     * @param int             $options
     *
     * @return static
     */
    public function sort_by_desc($callback, $options = SORT_REGULAR)
    {
        return $this->sort_by($callback, $options, true);
    }

    /**
     * Sort the collection keys.
     *
     * @param int  $options
     * @param bool $descending
     *
     * @return static
     */
    public function sort_keys($options = SORT_REGULAR, $descending = false)
    {
        $items = $this->items;
        $descending ? krsort($items, $options) : ksort($items, $options);

        return new static($items);
    }

    /**
     * Sort the collection keys in descending order.
     *
     * @param int $options
     *
     * @return static
     */
    public function sort_keys_desc($options = SORT_REGULAR)
    {
        return $this->sort_keys($options, true);
    }

    /**
     * Splice a portion of the underlying collection array.
     *
     * @param int      $offset
     * @param int|null $length
     * @param mixed    $replacement
     *
     * @return static
     */
    public function splice($offset, $length = null, $replacement = [])
    {
        if (func_num_args() === 1) {
            return new static(array_splice($this->items, $offset));
        }

        return new static(array_splice($this->items, $offset, $length, $replacement));
    }

    /**
     * Get the sum of the given values.
     *
     * @param callable|string|null $callback
     *
     * @return mixed
     */
    public function sum($callback = null)
    {
        if (is_null($callback)) {
            return array_sum($this->items);
        }

        $callback = $this->value_retriever($callback);

        return $this->reduce(function ($result, $item) use ($callback) {
            return $result + $callback($item);
        }, 0);
    }

    /**
     * Take the first or last {$limit} items.
     *
     * @param int $limit
     *
     * @return static
     */
    public function take($limit)
    {
        return ($limit < 0) ? $this->slice($limit, abs($limit)) : $this->slice(0, $limit);
    }

    /**
     * Pass the collection to the given callback and then return it.
     *
     * @param callable $callback
     *
     * @return $this
     */
    public function tap(callable $callback)
    {
        $callback(new static($this->items));
        return $this;
    }

    /**
     * Transform each item in the collection using a callback.
     *
     * @param callable $callback
     *
     * @return $this
     */
    public function transform(callable $callback)
    {
        $this->items = $this->map($callback)->all();
        return $this;
    }

    /**
     * Return only unique items from the collection array.
     *
     * @param string|callable|null $key
     * @param bool                 $strict
     *
     * @return static
     */
    public function unique($key = null, $strict = false)
    {
        $callback = $this->value_retriever($key);
        $exists = [];

        return $this->reject(function ($item, $key) use ($callback, $strict, &$exists) {
            if (in_array($id = $callback($item, $key), $exists, $strict)) {
                return true;
            }

            $exists[] = $id;
        });
    }

    /**
     * Return only unique items from the collection array using strict comparison.
     *
     * @param string|callable|null $key
     *
     * @return static
     */
    public function unique_strict($key = null)
    {
        return $this->unique($key, true);
    }

    /**
     * Reset the keys on the underlying array.
     *
     * @return static
     */
    public function values()
    {
        return new static(array_values($this->items));
    }

    /**
     * Get a value retrieving callback.
     *
     * @param callable|string|null $value
     *
     * @return callable
     */
    protected function value_retriever($value)
    {
        if ($this->use_as_callable($value)) {
            return $value;
        }

        return function ($item) use ($value) {
            return data_get($item, $value);
        };
    }

    /**
     * Zip the collection together with one or more arrays.
     *
     * @param mixed ...$items
     *
     * @return static
     */
    public function zip($items)
    {
        $arrayables = array_map(function ($items) {
            return $this->get_arrayable_items($items);
        }, func_get_args());

        $params = array_merge([function () {
            return new static(func_get_args());
        }, $this->items], $arrayables);

        return new static(call_user_func_array('array_map', $params));
    }

    /**
     * Pad collection to the specified length with a value.
     *
     * @param int   $size
     * @param mixed $value
     *
     * @return static
     */
    public function pad($size, $value)
    {
        return new static(array_pad($this->items, $size, $value));
    }

    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function to_array()
    {
        return $this->items;
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return array_map(function ($value) {
            if ($value instanceof \JsonSerializable) {
                return $value->jsonSerialize();
            }

            return $value;
        }, $this->items);
    }

    /**
     * Get the collection of items as JSON.
     *
     * @param int $options
     *
     * @return string
     */
    public function to_json($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Get an iterator for the items.
     *
     * @return \ArrayIterator
     */
    #[\ReturnTypeWillChange]
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * Get a CachingIterator instance.
     *
     * @param int  $flags
     *
     * @return \CachingIterator
     */
    public function getCachingIterator($flags = \CachingIterator::CALL_TOSTRING)
    {
        return new \CachingIterator($this->getIterator(), $flags);
    }

    /**
     * Count the number of items in the collection.
     *
     * @return int
     */
    #[\ReturnTypeWillChange]
    public function count()
    {
        return count($this->items);
    }

    /**
     * Count the number of items in the collection using a given truth test.
     *
     * @param callable|null $callback
     *
     * @return static
     */
    public function count_by($callback = null)
    {
        if (is_null($callback)) {
            $callback = function ($value) {
                return $value;
            };
        }

        return new static($this->group_by($callback)->map(function ($value) {
            return $value->count();
        }));
    }

    /**
     * Add an item to the collection.
     *
     * @param mixed $item
     *
     * @return $this
     */
    public function add($item)
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * Get a base Support collection instance from this collection.
     *
     * @return Collection
     */
    public function to_base()
    {
        return new self($this);
    }

    /**
     * Determine if an item exists at an offset.
     *
     * @param mixed $key
     *
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Get an item at a given offset.
     *
     * @param mixed $key
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    /**
     * Set the item at a given offset.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param string $key
     *
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    /**
     * Convert the collection to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->to_json();
    }

    /**
     * Results array of items from Collection or Arrayable.
     *
     * @param mixed $items
     *
     * @return array
     */
    protected function get_arrayable_items($items)
    {
        if (is_array($items)) {
            return $items;
        } elseif ($items instanceof self) {
            return $items->all();
        } elseif ($items instanceof \JsonSerializable) {
            return (array) $items->jsonSerialize();
        } elseif ($items instanceof \Traversable) {
            return iterator_to_array($items);
        }

        return (array) $items;
    }

    /**
     * Add a method to the list of proxied methods.
     *
     * @param string $method
     *
     * @return void
     */
    public static function proxy($method)
    {
        static::$proxies[] = $method;
    }

    /**
     * Dynamically access collection proxies.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        if (!in_array($key, static::$proxies)) {
            throw new \Exception('Property [' . $key . '] does not exist on this collection instance.');
        }

        return $this->{$key}(function ($value) use ($key) {
            return is_array($value) ? $value[$key] : $value->{$key};
        });
    }
}
