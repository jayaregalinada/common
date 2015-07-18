# Jag\Common

[![Author](http://img.shields.io/badge/author-@jayaregalinada-blue.svg?style=flat-square)](https://github.com/jayaregalinada)
[![Packagist Version](https://img.shields.io/packagist/v/jag/common.svg?style=flat-square)](https://packagist.org/packages/jag/common)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Laravel](http://img.shields.io/badge/Laravel-~5-orange.svg?style=flat-square)](http://laravel.com)

Nah, some boilerplate here


## Included Packages

- [Socialite](https://github.com/laravel/socialite) - Fluent interface to OAuth authentication
- [Image](https://github.com/Intervention/image) - PHP Image Manipulation
- [Html\Form](https://github.com/illuminate/html) - Illuminate HTML component
- [Entrust](https://github.com/Zizaco/entrust) - Role-based Permissions


## Install

Via Composer

``` bash
$ composer require jag/common
```

## Optional Facade

Edit and Add your `config\app.php` at `aliases` array key with
``` php
'aliases' => [
    'Socialite' => 'Laravel\Socialite\Facades\Socialite',
    'Image'     => 'Intervention\Image\Facades\Image',
    'Html'      => 'Illuminate\Html\HtmlFacade',
    'Form'      => 'Illuminate\Html\FormFacade',
    'Entrust'   => 'Zizaco\Entrust\EntrustFacade',
],
```
You can also use the class name resolution via [`::class`](http://php.net/manual/en/language.oop5.basic.php#language.oop5.basic.class.class) specially for `PHP => 5.5` and `Laravel ~5.1`

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email jayaregalinada@gmail.com instead of using the issue tracker.

## Credits

- [Jay Are Galinada](https://github.com/jayaregalinada)


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

