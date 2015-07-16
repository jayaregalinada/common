<?php

return [

    /**
     * Title of your website
     */
    'title' => 'Application Title',

    /**
     * Owner information
     */
    'owner' => [
        'type' => 'single', // [single|group]
        'name' => 'Application Owner Name',
        'email' => 'application@owner.email',
    ],

    'address' => 'Application Address',

    'url' => env('APP_URL', 'http://localhost'),

    'timezone' => env('APP_TIMEZONE', 'Asia/Manila'),

    'providers' => [

        /*
         * Third Party Service Providers...
         * We use this prior for v5.0 compatibility
         */
        'Laravel\Socialite\SocialiteServiceProvider',
        'Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider',
        'Intervention\Image\ImageServiceProvider',
        'Illuminate\Html\HtmlServiceProvider',
        'Orangehill\Iseed\IseedServiceProvider',
        'Clockwork\Support\Laravel\ClockworkServiceProvider',
        'Zizaco\Entrust\EntrustServiceProvider',
        'JeroenG\Packager\PackagerServiceProvider',
    ],

    'aliases' => [
        /*
         * Third Party Service Aliases...
         * We use this prior for v5.0 compatibility
         */
        'Socialize' => 'Laravel\Socialite\Facades\Socialite',
        'Image'     => 'Intervention\Image\Facades\Image',
        'Html'      => 'Illuminate\Html\HtmFacade',
        'Form'      => 'Illuminate\Html\FormFacade',
        'Entrust'   => 'Zizaco\Entrust\EntrustFacade',
    ]
];
