<?php

namespace Styde\QueryFilter\Tests\Units;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Styde\QueryFilter\Tests\Models\User;
use Styde\QueryFilter\Tests\TestCase;

class QueryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function check_what_is_searched_by_email_with_the_userquery_functions()
    {
        $user = User::query()->create(['name' => 'Luis', 'email' => 'luis@email.com']);
        User::query()->create(['name' => 'Styde', 'email' => 'styde@email.com']);

        $this->assertEquals($user->getKey(), User::query()->findByEmail('luis@email.com')->getKey());
    }

    /** @test */
    public function check_that_it_is_filtered_by_the_prefix_email_or_name_with_the_userquery_functions()
    {
        User::query()->create(['name' => 'Luis', 'email' => 'luis@email.com']);
        User::query()->create(['name' => 'Duilio', 'email' => 'admin@styde.com']);
        User::query()->create(['name' => 'styde support', 'email' => 'support@styde.com']);

        $this->assertNotContains('luis@email.com',
            User::query()->filterByPrefixEmail('styde.com')
                ->filterByOrName('styde')->get()->pluck('email')->toArray()
        );

        $this->assertNotContains('Luis',
            User::query()->filterByPrefixEmail('styde.com')
                ->filterByOrName('styde')->get()->pluck('name')->toArray()
        );
    }
}
