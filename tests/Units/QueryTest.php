<?php

namespace Styde\QueryFilter\Tests\Units;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Styde\QueryFilter\Tests\Models\User;
use Styde\QueryFilter\Tests\TestCase;

class QueryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function using_a_single_query_method()
    {
        $user = User::query()->create(['name' => 'Luis', 'email' => 'luis@email.com']);
        User::query()->create(['name' => 'Styde', 'email' => 'styde@email.com']);

        $this->assertEquals($user->getKey(), User::query()->findByEmail('luis@email.com')->getKey());
    }

    /** @test */
    public function using_a_multiple_query_method()
    {
        User::query()->create(['name' => 'Luis', 'email' => 'luis@email.com']);
        User::query()->create(['name' => 'styde admin', 'email' => 'admin@styde.com']);
        User::query()->create(['name' => 'styde support', 'email' => 'support@styde.com']);

        $this->assertTrue(
            User::query()->filterByPrefixEmail('styde')
                ->filterByOrName('styde')->count() == 2
        );
    }
}
