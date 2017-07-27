# Eloquent Vars

[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

Add ability to save additional fields or Vars on a Laravel model without a specific db column for it

## Install

Via Composer

``` bash
$ composer require sdavis1902/eloquent-vars
```

Add the service provider

``` php
sdavis1902\EloquentVars\EloquentVarsServiceProvider::class,
```

Publish and run migration
``` bash
$ php artisan vendor:publish --provider="sdavis1902\EloquentVars\EloquentVarsServiceProvider"
$ php artisan:migrate
```

## Usage

Add the trait to your model

``` php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use sdavis1902\EloquentVars\EloquentVarsTrait;

class Task extends Model {

    use EloquentVarsTrait;
```

Now you can do the following...

``` php
$task->setVar('temporary_field', 'The value');
$task->setVar('temporary_id', 1);

echo $task->getVar('temporary_field');

$task->deleteVar('temporary_field');
```

Note, values are stored as a string, so if you save an int, when you get it, it will be a string.

Will add more ways of saving and retrieving vars in the near future.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Credits

- [Scott Davis][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sdavis1902/eloquent-vars.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/sdavis1902/eloquent-vars/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/sdavis1902/eloquent-vars.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/sdavis1902/eloquent-vars.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sdavis1902/eloquent-vars.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sdavis1902/laravel-controller-routes
[link-travis]: https://travis-ci.org/sdavis1902/laravel-controller-routes
[link-scrutinizer]: https://scrutinizer-ci.com/g/sdavis1902/laravel-controller-routes/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/sdavis1902/laravel-controller-routes
[link-downloads]: https://packagist.org/packages/sdavis1902/laravel-controller-routes
[link-author]: https://github.com/sdavis1902
[link-contributors]: ../../contributors
