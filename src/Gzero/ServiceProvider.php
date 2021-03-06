<?php namespace Gzero;

use Config;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider as SP;
use Symfony\Component\HttpFoundation\Request;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class ServiceProvider
 *
 * @package    Gzero
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class ServiceProvider extends SP {

    protected $providers = [
        'Bigecko\LaravelTheme\LaravelThemeServiceProvider',
        'Robbo\Presenter\PresenterServiceProvider',
        'Barryvdh\TwigBridge\ServiceProvider',
        'Gzero\Repositories\RepositoryServiceProvider',
        'Gzero\Api\ServiceProvider',
        'Gzero\UserPanel\ServiceProvider',
        'Gzero\Admin\ServiceProvider'
    ];

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('gzero/gzero-cms', NULL, __DIR__ . '/../');
        $this->registerHelpers();
        $this->registerFilters();
        $this->detectLanguage();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        AliasLoader::getInstance()->alias('Eloquent', 'Gzero\EloquentBaseModel\Model\Base'); // Override Eloquent Model

        $this->registerAdditionalProviders();
        /**
         * Register default content types
         */
        $this->app->bind('type:content', 'Gzero\Handlers\Content\Content');
        $this->app->bind('type:category', 'Gzero\Handlers\Content\Category');
        /**
         * Register default block types
         */
        $this->app->bind('block_type:basic', 'Gzero\Handlers\Block\Basic');
        $this->app->bind('block_type:menu', 'Gzero\Handlers\Block\Menu');
        $this->app->bind('block_type:slider', 'Gzero\Handlers\Block\Slider');
    }

    /**
     * Trying to detect language from uri
     */
    protected function detectLanguage()
    {
        if (\Request::segment(1) != 'admin' and Config::get('gzero-cms::multilang.enabled')) {
            if (Config::get('gzero-cms::multilang.subdomain')) {
                $locale = preg_replace('/\..+$/', '', Request::getHost());
            } else {
                $locale = \Request::segment(1);
            }
            $languages = array('pl', 'en');
            if (in_array($locale, $languages, TRUE)) {
                App::setLocale($locale);
                Config::set('gzero-cms::multilang.detected', TRUE);
            }
        }
    }

    /**
     * Register additional providers to system
     */
    protected function registerAdditionalProviders()
    {
        foreach ($this->providers as $provider) {
            App::register($provider);
        }
    }

    /**
     * Add additional file to store filers
     */
    protected function registerFilters()
    {
        require __DIR__ . '/../filters.php';
    }

    /**
     * Add additional file to store helpers
     */
    protected function registerHelpers()
    {
        require_once __DIR__ . '/../helpers.php';
    }
}
