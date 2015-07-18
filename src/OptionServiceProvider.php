<?php

namespace Jag\Common;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class OptionServiceProvider extends ServiceProvider
{

    /**
     * @var string
     */
    const CACHENAME = 'jag\common::optionMigrationName';

    /**
     * @return string
     */
    protected function getMigrationName()
    {
        return 'common_create_options_table';
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
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        config( $this->getDatabaseConfig() );
    }

    public function getDatabaseConfig()
    {
        if(Schema::hasTable('options')) {
            $table = $this->app['db']->table('options');

            return $this->changeConfigWithHelpers( $table->where( 'type', 'config' )->lists( 'value', 'key' ) );
        }
    }

    /**
     * @param array $config
     *
     * @return array
     */
    private function changeConfigWithHelpers( array $config )
    {
        foreach( $config as $key => $value ) {
            $config[ $key ] = ( empty( trim( unserialize( base64_decode( $value ) ) ) ) ? config( $key ) : $this->replaceHelpers( unserialize( base64_decode( $value ) ) ) );
        }

        return $config;
    }

    /**
     * @param $string
     *
     * @return mixed
     */
    public function replaceHelpers($string)
    {
        $helper = [
            '__TITLE__' => config('app.title'),
            '__YEAR__'  => date('Y'),
        ];

        return str_replace(array_keys( $helper ), array_values( $helper ), $string);
    }

}
