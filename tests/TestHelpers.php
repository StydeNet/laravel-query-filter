<?php

namespace Styde\QueryFilter\Tests;

use Illuminate\Support\Str;
use Styde\QueryFilter\Tests\Models\User;

trait TestHelpers
{
    public function createUsers($attributes = [])
    {
        return User::create(array_merge([
            'name' => Str::random(),
            'email' => sprintf('%s@%s.com', Str::random('8'), Str::random('4'))
        ], $attributes));
    }

    public function createManyUsers($times, $attributes = [])
    {
        for ($i = 0; $i < $times; $i++) {
            User::create(array_merge([
                'name' => Str::random(),
                'email' => sprintf('%s@%s.com', Str::random('8'), Str::random('4'))
            ], $attributes));
        }
    }
}
