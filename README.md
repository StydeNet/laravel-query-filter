# Laravel Query Filter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/styde/laravel-query-filter.svg?style=flat-square)](https://packagist.org/packages/styde/laravel-query-filter)
[![Build Status](https://img.shields.io/travis/styde/laravel-query-filter/master.svg?style=flat-square)](https://travis-ci.org/styde/laravel-query-filter)
[![Quality Score](https://img.shields.io/scrutinizer/g/styde/laravel-query-filter.svg?style=flat-square)](https://scrutinizer-ci.com/g/styde/laravel-query-filter)
[![Total Downloads](https://img.shields.io/packagist/dt/styde/laravel-query-filter.svg?style=flat-square)](https://packagist.org/packages/styde/laravel-query-filter)

This is a package that was born in styde.net, my job was just to adapt said logic to make it a package and add some salt to improve it a bit.

## Installation

You can install the package via composer:

```bash
composer require styde/laravel-query-filter
```

## Usage

You can use `make:query` to create a new QueryClass or you can use `make:filter` to create a new FilterClass.

Once these classes are created, you must be able to incorporate the logic that you require within them. 
Remember, the `FilterClass` serves as a filter for queries made from requests.

Something that you must bear in mind is that your Query class must be associated with the model for which you created it, this is vital so that your filters work otherwise you will get errors.

I will show you an example of use, thinking about the User model.

##### Command make:query

```bash
php artisan make:query UserQuery
```

This command will create a php file named User Query with the following structure.

```php
<?php

namespace App\Queries;

use Styde\LaravelQueryFilter\QueryBuilder;

class UserQuery extends QueryBuilder
{
    //
}
```

##### Command make:query

```bash
php artisan make:query UserFilter
```

This command will create a php file named User Filter with the following structure.

```php
<?php

namespace App\Filters;

use Styde\LaravelQueryFilter\AbstractFilter;

class UserFilter extends AbstractFilter
{
    /**
     * Get the validation rules that apply to the request filter.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
```

Once you have created these classes you must associate the `QueryClass` to the model in question as follows.
Also if you don't want to create a `QueryClass` you can use the BaseQuery `Styde\LaravelQueryFilter\QueryBuilder` from which the queries created by command extends.

```php
<?php

namespace App\Models;

use App\Filters\UserFilter;
use App\Queries\UserQuery;

class User extends Authenticatable
{
    //

    // We associate the query
    public function newEloquentBuilder($query)
    {
        return new UserQuery($query);
    }

    // We associate the filter
    public function newQueryFilter()
    {
        return new UserFilter;
    }
}
```

or 

```php
<?php

namespace App\Models;

use App\Filters\UserFilter;
use Styde\LaravelQueryFilter\QueryBuilder;

class User extends Authenticatable
{
    //

    // We associate the query
    public function newEloquentBuilder($query)
    {
        return new QueryBuilder($query);
    }

    // We associate the filter
    public function newQueryFilter()
    {
        return new UserFilter;
    }
}
```

Once this is done, we are going to create a basic query filter and a basic query that will help us search for a user by email.

##### In your UserQuery file

```php
<?php

namespace App\Queries;

use Styde\LaravelQueryFilter\QueryBuilder;

class UserQuery extends QueryBuilder
{
    public function findByEmail($email)
    {
        return $this->where(compact('email'))->first();
    }
}
```

Now you can use this query wherever you want in the following way:

```php
// Anywhere in your project

$user = User::query()->findByEmail('luilliarcec@gmail.com');
```

##### In your UserFilter file

Normally the filters are applied when we make a list of records, commonly the index method of our controller, we will use that case to explain the filters.

```php
<?php

namespace App\Filters;

use Styde\LaravelQueryFilter\AbstractFilter;

class UserFilter extends AbstractFilter
{
    /**
     * Get the validation rules that apply to the request filter.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'search' => 'filled'
        ];
    }

    public function search($query, $value)
    {
        return $query->where('email', 'like', "{$value}%")
            ->orWhere('name', 'like', "{$value}%");
    }
}
```

In your UserController

```php
<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->applyFilters()->paginate();

        return view('users.index', compact('users'));
    }
}
```

This way you are returning the filtered records. 

###### Remember 

* The filters that are applied are the ones passed by the rules in UserFilter, if you want to add more filters you must, put in rules the name of the input that arrives in the request, and create a function in your filter with the name of the input in camelCase.

* If you have more than one class of filters for the same model, you can apply it from the controller passing it as dependency injection, even if you want to pass your own values you can do it by passing an array of key => value as the second parameter

Example

In your UserController

```php
<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function index()
    {
        $otherData = [
            // 
        ];

        $users = User::query()->applyFilters(new OtherUserFilter(), $otherData)->paginate();

        return view('users.index', compact('users'));
    }
}
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email luilliarcec@gmail.com instead of using the issue tracker.

## Credits

- [Duilio Palacios.](https://github.com/sileence)
- [Luis Andrés Arce C.](https://github.com/luilliarcec)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
