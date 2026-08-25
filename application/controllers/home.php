<?php

defined('DS') or exit('No direct script access.');

use Docs\Libraries\Docs;

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

        $packages = Repo::packages();

        return View::make('home.index')
            ->with('page', $this->page)
            ->with('featured', array_slice($packages, 0, 8))
            ->with('package_count', count($packages))
            ->with('category_count', count(Repo::categorize($packages, 'category')))
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
     * Handle GET /sitemap.xml.
     *
     * @return Response
     */
    public function action_sitemap()
    {
        Package::boot('docs');

        $views = path('app') . 'views' . DS . 'home' . DS;
        $urls = [
            url('/') => @filemtime($views . 'index.blade.php'),
            rtrim(url('repositories'), '/') => @filemtime($views . 'repositories.blade.php'),
        ];

        // `/download` sengaja dilewat, ia hanya redirect ke Github.
        foreach (Docs::pages() as $url => $mtime) {
            $urls[$url] = $mtime;
        }

        $xml = ['<?xml version="1.0" encoding="UTF-8"?>'];
        $xml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url => $mtime) {
            $xml[] = '    <url>';
            $xml[] = '        <loc>' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '</loc>';
            $xml[] = '        <lastmod>' . date(DATE_W3C, $mtime ? $mtime : time()) . '</lastmod>';
            $xml[] = '    </url>';
        }

        $xml[] = '</urlset>';

        return Response::make(implode(PHP_EOL, $xml), 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
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
        $perpage = 8;
        $query = trim((string) Request::foundation()->query->get('q'));
        $packages = Repo::packages();
        $view = View::make('home.repositories');

        $view->brand = 'Rakit';
        $view->page = $this->page;
        $view->count = count($packages);
        $view->query = $query;

        $items = Repo::categorize($packages, 'category');
        $keys = array_keys($items);
        asort($keys);

        $categories = [];

        foreach ($keys as $key) {
            $categories[] = ['name' => $key, 'count' => count($items[$key])];
        }

        if (is_null($name)) {
            $view->categories = $categories;
        } else {
            if (!in_array($name, $keys)) {
                return Response::error(404);
            }

            $view->category = Str::slug($name);
            $view->categories = $categories;
            $packages = $items[$name];
        }

        $packages = Repo::search($packages, $query);

        $view->matched = count($packages);
        $view->current = Repo::current();
        $view->last = max(1, (int) ceil(count($packages) / $perpage));
        $view->packages = Repo::paginate($packages, Repo::current(), $perpage);

        if ($view->current > $view->last || ($view->current > 1 && empty($view->packages))) {
            return Response::error(404);
        }

        return $view;
    }
}
