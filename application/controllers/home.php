<?php

defined('DS') or exit('No direct script access.');

class Home_Controller extends Base_Controller
{
    /**
     * Nama halaman saat ini.
     *
     * @var string
     */
    public $page;

    /**
     * Teks untuk tagline.
     *
     * @var string
     */
    public $tagline;

    /**
     * Teks untuk navbar brand.
     *
     * @var string
     */
    public $brand;

    /**
     * Konstruktor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->brand = 'Rakit';
        $this->tagline = 'Kerangka kerja PHP sederhana, ringan dan modular.';

        $page = URI::current();
        $page = ('/' === $page) ? 'home' : str_replace('/', ' ~ ', $page);
        $page = Str::title($page).' | '.$this->tagline;
        $this->page = $page;
    }

    /**
     * Handle GET /.
     *
     * @return View
     */
    public function action_index()
    {
        $view = View::make('home.index');

        $view->brand = $this->brand;
        $view->tagline = $this->tagline;
        $view->page = $this->page;

        return $view;
    }

    /**
     * Handle GET /key.
     *
     * @return View
     */
    public function action_key()
    {
        return View::make('home.key')
            ->with_page($this->page)
            ->with_key(Str::random(32));
    }

    /**
     * Handle GET /download.
     *
     * @return Redrect
     */
    public function action_download()
    {
        return Redirect::to('https://github.com/esyede/rakit/archive/'.RAKIT_VERSION.'.zip');
    }

    /**
     * Handle GET /repositories[/category].
     *
     * @return View|Response
     */
    public function action_repositories($name = null)
    {
        $perpage = 1;
        $verbatim = Stuff::packages();
        $view = View::make('home.repositories');

        $view->brand = $this->brand;
        $view->tagline = $this->tagline;
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
            $view->catname = 'semua';
            $view->categories = $categories;
            $view->currpage = Stuff::currpage();
            $view->totalpage = (int) ceil(count($verbatim) / $perpage);
            $view->packages = Stuff::paging($verbatim, Stuff::currpage(), $perpage);

            if (empty($view->packages) || $view->currpage > $view->totalpage) {
                return Response::error('404');
            }
        } else {
            if (! in_array($name, $keys)) {
                return Response::error('404');
            }

            $view->catname = Str::slug($name);
            $view->categories = $categories;
            $view->currpage = Stuff::currpage();
            $view->totalpage = (int) ceil(count($categorized[$name]) / $perpage);
            $view->packages = Stuff::paging($categorized[$name], Stuff::currpage(), $perpage);

            if (empty($view->packages) || $view->currpage > $view->totalpage) {
                return Response::error('404');
            }
        }

        return $view;
    }
}
