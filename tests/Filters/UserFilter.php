<?php

namespace Styde\LaravelQueryFilter\Tests\Filters;

use Styde\LaravelQueryFilter\AbstractFilter;
use Styde\LaravelQueryFilter\Tests\Queries\UserQuery;

class UserFilter extends AbstractFilter
{
    protected function rules(): array
    {
        return [
            'search' => 'filled'
        ];
    }

    public function search(UserQuery $builder, $value)
    {
        return $builder->where('email', 'like', "{$value}%")
            ->filterByOrName($value);
    }
}
