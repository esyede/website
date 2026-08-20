<?php

defined('DS') or exit('No direct script access.');

class Home_Controller extends Controller
{
    /**
     * Site slogan.
     *
     * @var string
     */
    const SLOGAN = 'A simple, lightweight and modular PHP framework.';

    /**
     * Maximum number of files to keep in storage folders.
     *
     * @var int
     */
    const STORAGE_LIMIT = 100;

    /**
     * Current page.
     *
     * @var int
     */
    private $page;

    /**
     * Create a new Home_Controller instance.
     */
    public function __construct()
    {
        $page = URI::current();
        $page = ('/' === $page) ? 'home' : str_replace('/', ' ~ ', $page);
        $this->page = Str::title($page) . ' | ' . static::SLOGAN;
    }

    /**
     * Handle GET /.
     *
     * @return View
     */
    public function action_index()
    {
        $this->sweep_storage();

        return View::make('home.index')
            ->with('page', $this->page)
            ->with('news', vsprintf('Connect with other developers through our discussion board <a href="%s" target="_blank">%s</a>', [
                'https://github.com/esyede/rakit/discussions/categories/paket-library',
                'Learn more..',
            ]));
    }

    /**
     * Sweep storage folders to remove unused files.
     *
     * @return void
     */
    private function sweep_storage()
    {
        $keep = ['.gitignore', 'index.html'];
        $folders = ['sessions', 'views', 'cache', 'logs'];

        foreach ($folders as $folder) {
            $files = glob(path('storage') . $folder . DS . '*');

            if (!is_array($files)) {
                continue;
            }

            $files = array_filter($files, function ($file) use ($keep) {
                return is_file($file) && !in_array(basename($file), $keep);
            });

            if (count($files) <= static::STORAGE_LIMIT) {
                continue;
            }

            foreach ($files as $file) {
                @unlink($file);
            }
        }
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
