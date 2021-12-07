<?php

namespace Esyede\LanguageBuilder;

defined('DS') or die('No direct script access.');

use System\Package;
use System\Config;
use System\Input;
use System\URL;

class Utilities
{
    public static function get_files($name, $location, $translation)
    {
        $path = Package::path($location);

        if (! is_file($path.'language/'.$translation.'/'.$name.'.php')) {
            return;
        }

        $langdir = Config::get('language-builder::builder.base_lang');
        $language['from'] = require $path.'language/'.$langdir.'/'.$name.'.php';
        $language['to'] = require $path.'language/'.$translation.'/'.$name.'.php';

        return $language;
    }

    public static function link(array $file = [])
    {
        if (! is_array($file['location'])) {
            $query = [
                'location' => $file['location'],
                'name' => $file['name'],
                'translate' => Input::get('translate'),
            ];

            $text = $file['name'];
        } else {
            $query = [
                'location' => $file['location']['location'],
                'name' => $file['name'],
                'translate' => Input::get('translate'),
            ];

            $text = $file['location']['location'].'/'.$file['name'];
        }

        $query = http_build_query($query);
        return '<a href="'.URL::to('language-builder/edit?'.$query).'">'.$text.'</a>';
    }

    public static function make_array($lang)
    {
        $out = "<?php\n\ndefined('DS') or die('No direct script access.');\n\nreturn [\n";
        $out .= static::build_array($lang);

        return $out.'];';
    }

    protected static function build_array($lang, $depth = 1)
    {
        $out = '';

        foreach ($lang as $key => $value) {
            if (is_array($value)) {
                $out .= str_repeat("\t", $depth)."'".$key."' => [\n";
                $out .= static::build_array($value, ++$depth)."\n";
                $out .= str_repeat("\t", --$depth)."],\n";
                $depth = 1;
                continue;
            }

            $out .= str_repeat("\t", $depth)."'".$key."' => '".addcslashes($value, "'\\/")."',\n";
        }

        return $out;
    }
}
