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
     * Konstruktor.
     */
    public function __construct()
    {
        parent::__construct();

        $language = (Request::foundation()->getPreferredLanguage() == 'id_ID') ? 'id' : 'en';
        Config::set('application.language', $language);

        $page = URI::current();
        $page = ('/' === $page) ? 'home' : str_replace('/', ' ~ ', $page);
        $page = Str::title($page).' | '.__('home.hero.slogan');
        $this->page = $page;
    }

    /**
     * Handle GET /.
     *
     * @return View
     */
    public function action_index()
    {
        $view = view('home.index');
        $view->page = $this->page;
        $view->news = __('home.news.text', [
            'version' => RAKIT_VERSION,
            'more' => '<a href="'.url('forum/topic4-rakit-v099-siap-diuji-coba.html').'" target="_blank">'.__('home.news.more').'</a>',
        ]);

        return $view;
    }

    /**
     * Handle GET /key.
     *
     * @return View
     */
    public function action_key()
    {
        return Response::json([
            'key' => Str::random(32),
            'message' => "Copy this key into your 'Application Key' config in application/config/application.php",
        ], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Handle GET /download.
     *
     * @return Redrect
     */
    public function action_download()
    {
        Log::filename('downloads');
        Log::info('Download from: '.Request::ip());
        Log::filename(null);

        return redirect('https://github.com/esyede/rakit/archive/master.zip');
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
        $view = view('home.repositories');

        $view->brand = 'Rakit';
        $view->tagline = __('home.hero.slogan');
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
            $view->catname = Str::slug(__('repo.content.all'));
            $view->categories = $categories;
            $view->currpage = Stuff::currpage();
            $view->totalpage = (int) ceil(count($verbatim) / $perpage);
            $view->packages = Stuff::paging($verbatim, Stuff::currpage(), $perpage);

            if (empty($view->packages) || $view->currpage > $view->totalpage) {
                return Response::error(404);
            }
        } else {
            if (! in_array($name, $keys)) {
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
