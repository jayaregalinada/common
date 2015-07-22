# Jag\Common

[![Author](http://img.shields.io/badge/author-@jayaregalinada-blue.svg?style=flat-square)](https://github.com/jayaregalinada)
[![Packagist Version](https://img.shields.io/packagist/v/jag/common.svg?style=flat-square)](https://packagist.org/packages/jag/common)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Laravel](http://img.shields.io/badge/Laravel-~5-orange.svg?style=flat-square)](http://laravel.com)

Nah, some boilerplate here. All included packages service provider are already registered.

Option service are not included out-of-the-box, instead add its service provider. See [below](#option-service-provider) for instruction.

## Table of Contents

- [Included Packages](#included-packages)
- [Install](#install)
- [Post Install](#post-install)
 - [IDE Helper](#ide-helper)
 - [Option Service Provider](#option-service-provider)
 - [Clockwork Middleware](#clockwork-middleware)
 - [How to use Laravel Packager](#how-to-use-laravel-packager)
- [Optional Facade](#optional-facade)
- [Change Log](#change-log)
- [Security](#security)
- [Credits](#credits)
- [License](#license)

## Included Packages

- [Socialite](https://github.com/laravel/socialite) - Fluent interface to OAuth authentication
- [Image](https://github.com/Intervention/image) - PHP Image Manipulation
- [Image(Cache)](https://github.com/Intervention/imagecache) - Caching extension for the Intervention Image Class
- [Html/Form](https://github.com/illuminate/html) - Illuminate HTML component
- [Entrust](https://github.com/Zizaco/entrust) - Role-based Permissions
- [HTML Sanitizer](mailto:zefredz@gmail.com)- HTML Sanitizer
- [iSeed](https://github.com/orangehill/iseed) - Inverse seed generator
- [Whoops](https://github.com/filp/whoops) - PHP errors for cool kids
- [Clockwork](https://github.com/itsgoingd/clockwork) - Chrome extension for PHP development


## Install

Via Composer

``` bash
$ composer require jag/common
```

## Post Install

After the installation complete, run

``` bash
$ php artisan vendor:publish
```

Configurations from `clockwork`, `ide-helper`, `image`, `imagecache`, and `entrust` generated. A `users` migration will also be generated.

##### IDE Helper

After installing/updating composer, you can now re-generate the docs yourself

``` bash
$ php artisan ide-helper:generate
```

You can read the full documentation of [this package](https://github.com/barryvdh/laravel-ide-helper)

##### Option Service Provider

If you want to include the Option Service, add the service provider to the `$provider` array in `config/app.app`

```
'Jag\Common\OptionServiceProvider'
```

After that, publish the migrations.

``` bash
$ php artisan vendor:publish --provider="Jag\Common\OptionServiceProvider"
```

##### Clockwork Middleware

You need to add Clockwork middleware, in your `app/Http/Kernel.php`

``` php
protected $middleware = [
    'Clockwork\Support\Laravel\ClockworkMiddleware',
    ...
]
```

##### How to use Laravel Packager

This package provides you with a simple tool to set up a new packages. Nothing more, nothing less. Read more of its documentation [here](https://github.com/Jeroen-G/laravel-packager).

However, an [article](https://medium.com/@tabacitu/creating-laravel-5-packages-for-dummies-ec6a4ded2e93) teaches you to how to create packages.

## Optional Facade

Edit and Add your `config\app.php` at `$aliases` array
``` php
'aliases' => [
    ...
    'Socialite' => 'Laravel\Socialite\Facades\Socialite',
    'Image'     => 'Intervention\Image\Facades\Image',
    'Html'      => 'Illuminate\Html\HtmlFacade',
    'Form'      => 'Illuminate\Html\FormFacade',
    'Entrust'   => 'Zizaco\Entrust\EntrustFacade',
],
```
You can also use the class name resolution via [`::class`](http://php.net/manual/en/language.oop5.basic.php#language.oop5.basic.class.class) specially for `PHP => 5.5` and `Laravel ~5.1`

## Change Log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email jayaregalinada@gmail.com instead of using the issue tracker.

## Credits

- [Jay Are Galinada](https://github.com/jayaregalinada)
- [Frederic Minne](zefredz@gmail.com)


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

