<?php

namespace Esyede;

defined('DS') or exit('No direct script access.');

use System\Session;

class Notyf
{
    /**
     * Configurations.
     *
     * @var array
     */
    protected static $config = [
        'duration' => 2000,
        'dismissible' => false,
        'position' => 'right_top',
        'ripple' => true,
    ];

    /**
     * Valid positions.
     *
     * @var array
     */
    protected static $positions = [
        'right_top', 'right_center', 'right_bottom',
        'left_top', 'left_center', 'left_bottom',
        'center_top', 'center_center', 'center_bottom',
    ];

    /**
     * Make a success notification.
     *
     * @param string $message
     *
     * @return void
     */
    public static function success($message)
    {
        static::message($message, 'success');
    }

    /**
     * Make an error notification.
     *
     * @param string $message
     *
     * @return void
     */
    public static function error($message)
    {
        static::message($message, 'error');
    }

    /**
     * Make a notification.
     *
     * @param string $message
     * @param string $level
     *
     * @return void
     */
    protected static function message($message, $level = 'success')
    {
        Session::flash('notyf.message', $message);
        Session::flash('notyf.level', $level);
    }

    /**
     * Set notyf configuration.
     *
     * @param int    $duration
     * @param bool   $dismissible
     * @param string $position
     * @param bool   $ripple
     *
     * @return void
     */
    public static function config($duration = 2000, $dismissible = false, $position = 'right_top', $ripple = true)
    {
        $duration = ($duration < 2000) ? 2000 : (int) $duration;
        $dismissible = (bool) $dismissible;
        $ripple = (bool) $ripple;

        if (! in_array($position, static::$positions)) {
            throw new \Exception(sprintf('Position should be: %s, got: %s', implode(', ', static::$positions), $position));
        }

        static::$config = array_merge(static::$config, compact('duration', 'dismissible', 'position', 'ripple'));
    }

    /**
     * Get notyf CSS tag.
     *
     * @return string
     */
    public static function styles()
    {
        return '<link rel="stylesheet" href="'.asset('packages/notyf/css/notyf.min.css').'">';
    }

    /**
     * Get notyf JS tag.
     *
     * @return string
     */
    public static function scripts()
    {
        $content = '<script src="'.asset('packages/notyf/js/notyf.min.js').'"></script>'.PHP_EOL;

        if (Session::has('notyf.message')) {
            $config = (object) static::$config;
            $positions = explode('_', $config->position);
            $config->position = (object) ['x' => $positions[0], 'y' => $positions[1]];

            $type = Session::get('notyf.level');
            $config = json_encode($config);
            $message = str_replace('`', '\\`', Session::get('notyf.message'));
            $content .= sprintf('<script type="text/javascript">const notyf=new Notyf(%s);notyf.%s(`%s`);</script>%s',
                $config, $type, $message, PHP_EOL
            );
        }

        return $content;
    }
}
