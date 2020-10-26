<?php

namespace Styde\LaravelQueryFilter\Tests\Queries;

use Styde\LaravelQueryFilter\QueryBuilder;

class UserQuery extends QueryBuilder
{
    public function findByEmail($email)
    {
        return $this->where(compact('email'))->first();
    }

    public function filterByPrefixEmail($value)
    {
        return $this->where('email', 'like', "%{$value}");
    }

    public function filterByOrName($value)
    {
        return $this->orWhere('name', 'like', "{$value}%");
    }
}
