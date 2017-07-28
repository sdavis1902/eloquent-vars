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

Note, the above require the model object to have an id, so will need to have been written to the database already.

If you want use a more eloquent method, you can use the following.  Additionally, the following method will work on new model instances that have not been inserted yet.

``` php
// saving new model and it's vars all at once
$task = new \App\Task;
$task->name = 'Some Task';

// now our vars
$task->vars->first_var = 'test';

$task->save();

// retreiving a model and accessing it's vars directly
$task = \App\Task::find(1);
echo $task->vars->first_var;

// save another var
$task->vars->second_var = 'another test';
$task->save();

// if you try to get a var that doesn't exist, it simply returns null
var_dump($task->vars->no_var);
```

Additionally, the trait includes a relationship for the vars which allows you to eager load.  The above method of accessing vars uses this relationship, so you can eager load and then use the vars like above.

``` php
$tasks = \App\Task::with('ModelVars')->get();

foreach($tasks as $task){
    if($task->vars->first_var){
        echo $task->vars->first_var;
    }
}
```

Note, values are stored as a string, so if you save an int, when you get it, it will be a string.

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
