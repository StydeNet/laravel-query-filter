<?php

namespace Styde\LaravelQueryFilter\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Styde\LaravelQueryFilter\Tests\Filters\UserFilter;
use Styde\LaravelQueryFilter\Tests\Queries\UserQuery;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    public function newEloquentBuilder($query)
    {
        return new UserQuery($query);
    }

    public function newQueryFilter()
    {
        return new UserFilter();
    }
}
