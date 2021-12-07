<?php

defined('DS') or exit('No direct script access.');

use Esyede\LanguageBuilder\Dir;
use Esyede\LanguageBuilder\Compare;
use Esyede\LanguageBuilder\Utilities;

class Language_Builder_Home_Controller extends Controller
{
    public function action_index()
    {
        $languages = array_merge(
            ['' => __('language-builder::builder.please_select')],
            Config::get('language-builder::builder.languages')
        );

        return view('language-builder::home', compact('languages'));
    }

    public function action_build()
    {
        if ($translate = Input::get('translate')) {
            Dir::create_missing(Config::get('language-builder::builder.base_lang'), $translate);
            return Redirect::to('/language-builder/edit?translate='.$translate);
        }

        return Redirect::to('/language-builder');
    }

    public function action_edit()
    {
        $translate = Input::get('translate');
        $view = view('language-builder::layout');
        $view->base_lang = Config::get('language-builder::builder.base_lang');

        if (! $translate) {
            return Redirect::to('/language-builder');
        }

        $view->files = Compare::files(Config::get('language-builder::builder.base_lang'), $translate);

        $location = Input::get('location');
        $name = Input::get('name');

        if ($location && $name) {
            $view->edit = Utilities::get_files($name, $location, $translate);
            $view->lang_file = $name;
        }

        return $view;
    }

    public function action_update()
    {
        $location = Input::get('location');
        $name = Input::get('name');
        $translate = Input::get('translate');

        $file = Package::path($location).'language/'.$translate.'/'.$name.'.php';

        if (is_file($file)) {
            $array = Utilities::make_array($_POST['lang']);
            Storage::put($file, $array);
            $query = http_build_query(compact('location', 'name', 'translate'));

            return Redirect::to('/language-builder/edit?'.$query);
        }

        return Response::error('404');
    }
}
