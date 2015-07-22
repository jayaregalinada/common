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
- [HTML Sanitizer](mailto:zefredz@gmail.com)- HTML Sanitizer.


## Install

Via Composer

``` bash
$ composer require jag/common
```

## Post Install

##### IDE Helper

After installing/updating composer, you can now re-generate the docs yourself

``` bash
php artisan ide-helper:generate
```

You can read the full documentation of [this package](https://github.com/barryvdh/laravel-ide-helper)

##### Option Service Provider

If you want to include the Option Service, add the service provider to the `provider` array in `config/app.app`

```
'Jag\Common\OptionServiceProvider'
```

## Optional Facade

Edit and Add your `config\app.php` at `aliases` array key with
``` php
'aliases' => [
    ...,
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

