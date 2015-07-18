<?php

namespace Jag\Common;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{

    /**
     * @var string
     */
    const CACHENAME = 'jag\common::migrationName';

    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * Array of other providers
     *
     * @var array
     */
    protected $otherProviders = [
        'Laravel\Socialite\SocialiteServiceProvider',
        'Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider',
        'Intervention\Image\ImageServiceProvider',
        'Illuminate\Html\HtmlServiceProvider',
        'Orangehill\Iseed\IseedServiceProvider',
        'Clockwork\Support\Laravel\ClockworkServiceProvider',
        'Zizaco\Entrust\EntrustServiceProvider',
        'JeroenG\Packager\PackagerServiceProvider',
    ];

    /**
     * @return string
     */
    protected function getMigrationName()
    {
        return 'common_create_users_table';
    }

    /**
     * @return string
     */
    protected function getTimestampMigrationName()
    {
        if(!Cache::has(static::CACHENAME)) {
            Cache::forever(static::CACHENAME, date('Y_m_d_His') . '_' . $this->getMigrationName());
        }

        return Cache::get(static::CACHENAME);
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__. '/../database/migrations/'. $this->getMigrationName() .'.php' => database_path('migrations/' . $this->getTimestampMigrationName() .'.php')
        ], 'migrations');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__. '/../config/app.php', 'app'
        );
        $this->registerOtherProviders();
    }

    /**
     * Register the other providers
     *
     * @return void
     */
    protected function registerOtherProviders()
    {
        foreach ($this->otherProviders as $key => $value) {
            $this->app->register($value);
        }
    }

}
