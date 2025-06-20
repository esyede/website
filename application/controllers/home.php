<?php

defined('DS') or exit('No direct script access.');

class Home_Controller extends Controller
{
    /**
     * Bahasa default.
     *
     * @var string
     */
    private $lang = 'id';

    /**
     * Halaman saat ini.
     *
     * @var int
     */
    private $page;

    /**
     * Buat instance controller baru.
     */
    public function __construct()
    {
        $page = URI::current();
        $page = ('/' === $page) ? 'home' : str_replace('/', ' ~ ', $page);
        $this->page = Str::title($page) . ' | ' . trans('home.hero.slogan');
        $this->lang = (false !== stripos((string) Request::getPreferredLanguage(), 'id')) ? 'id' : 'en';
    }

    /**
     * Handle GET /.
     *
     * @return View
     */
    public function action_index()
    {
        // Hapus file tidak terpakai
        $files = glob(path('storage') . 'sessions' . DS . '*.session.php');
        if (is_array($files) && count($files) > 20) {
            foreach ($files as $file) {
                @unlink($file);
            }
            Cache::flush();
        }

        return View::make('home.index')
            ->with('page', $this->page)
            ->with('news', trans('home.news.text', [
                'more' => vsprintf('<a href="%s" target="_blank">%s</a>', [
                    'https://github.com/esyede/rakit/discussions/categories/paket-library',
                    trans('home.news.more')
                ]),
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

        return Redirect::to('https://github.com/esyede/rakit/archive/main.zip');
    }

    /**
     * Handle GET /repositories[/category].
     *
     * @return View|Response
     */
    public function action_repositories($name = null)
    {
        $perpage = 5;
        $packages = Repo::packages();
        $view = View::make('home.repositories');

        $view->brand = 'Rakit';
        $view->tagline = trans('home.hero.slogan');
        $view->page = $this->page;
        $view->count = count($packages);

        $items = Repo::categorize($packages, 'category');
        $keys = array_keys($items);
        asort($keys);

        $categories = [];

        foreach ($keys as $key) {
            $categories[] = ['name' => $key, 'count' => count($items[$key])];
        }

        if (is_null($name)) {
            $view->all = Str::slug(trans('repo.content.all'));
            $view->categories = $categories;
            $view->current = Repo::current();
            $view->last = (int) ceil(count($packages) / $perpage);
            $view->packages = Repo::paginate($packages, Repo::current(), $perpage);

            if (empty($view->packages) || $view->current > $view->last) {
                return Response::error(404);
            }
        } else {
            if (!in_array($name, $keys)) {
                return Response::error(404);
            }

            $view->category = Str::slug($name);
            $view->categories = $categories;
            $view->current = Repo::current();
            $view->last = (int) ceil(count($items[$name]) / $perpage);
            $view->packages = Repo::paginate($items[$name], Repo::current(), $perpage);

            if (empty($view->packages) || $view->current > $view->last) {
                return Response::error(404);
            }
        }

        return $view;
    }

    /**
     * Handle mocking for testing.
     *
     * @return string
     */
    public function action_mock($delay = 0)
    {
        if ($delay > 0) {
            sleep(intval($delay));
        }

        return Response::json([
            'headers' => Request::headers(),
            'method' => Request::method(),
            'queries' => Request::foundation()->query->all(),
            'data' => array_merge((array) Input::all(), [
                'json' => Input::json(),
                'stdin' => file_get_contents('php://input'),
            ]),
        ]);
    }
}
