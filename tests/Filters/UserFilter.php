<?php

namespace Styde\QueryFilter\Tests\Filters;

use Styde\QueryFilter\AbstractFilter;
use Styde\QueryFilter\Tests\Queries\UserQuery;

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
