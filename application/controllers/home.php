<?php

defined('DS') or exit('No direct script access.');

use System\Routing\Controller;
use System\Request;
use System\Config;
use System\Str;
use System\URI;
use System\View;
use System\URL;
use System\Log;
use System\Redirect;
use System\Response;

class Home_Controller extends Controller
{
    private $page;

    /**
     * Buat instance controller baru.
     */
    public function __construct()
    {
        $this->middleware('before', 'csrf|throttle:60,1');

        $language = (Request::foundation()->getPreferredLanguage() == 'id_ID') ? 'id' : 'en';
        Config::set('application.language', $language);

        $page = URI::current();
        $page = ('/' === $page) ? 'home' : str_replace('/', ' ~ ', $page);
        $page = Str::title($page) . ' | ' . trans('home.hero.slogan');
        $this->page = $page;
    }

    /**
     * Handle GET /.
     *
     * @return View
     */
    public function action_index()
    {
        return View::make('home.index')
            ->with('page', $this->page)
            ->with('news', trans('home.news.text', [
                'more' => '<a href="https://github.com/esyede/rakit/discussions" target="_blank">' . trans('home.news.more') . '</a>',
            ]));
    }

    /**
     * Handle GET /download
     *
     * @return Redirect
     */
    public function action_download()
    {
        Log::channel('downloads');
        Log::info('Download from: ' . Request::ip());
        Log::channel(null);

        return Redirect::to('https://github.com/esyede/rakit/archive/master.zip');
    }

    /**
     * Handle GET /repositories[/category].
     *
     * @return View|Response
     */
    public function action_repositories($name = null)
    {
        $perpage = 5;
        $verbatim = Stuff::packages();
        $view = view('home.repositories');

        $view->brand = 'Rakit';
        $view->tagline = trans('home.hero.slogan');
        $view->page = $this->page;
        $view->totalcount = count($verbatim);

        $categorized = Stuff::categorize($verbatim, 'category');
        $keys = array_keys($categorized);
        asort($keys);

        $categories = [];

        foreach ($keys as $key) {
            $categories[] = ['name' => $key, 'count' => count($categorized[$key])];
        }

        if (is_null($name)) {
            $view->catname = Str::slug(trans('repo.content.all'));
            $view->categories = $categories;
            $view->currpage = Stuff::currpage();
            $view->totalpage = (int) ceil(count($verbatim) / $perpage);
            $view->packages = Stuff::paging($verbatim, Stuff::currpage(), $perpage);

            if (empty($view->packages) || $view->currpage > $view->totalpage) {
                return Response::error(404);
            }
        } else {
            if (!in_array($name, $keys)) {
                return Response::error(404);
            }

            $view->catname = Str::slug($name);
            $view->categories = $categories;
            $view->currpage = Stuff::currpage();
            $view->totalpage = (int) ceil(count($categorized[$name]) / $perpage);
            $view->packages = Stuff::paging($categorized[$name], Stuff::currpage(), $perpage);

            if (empty($view->packages) || $view->currpage > $view->totalpage) {
                return Response::error(404);
            }
        }

        return $view;
    }
}
