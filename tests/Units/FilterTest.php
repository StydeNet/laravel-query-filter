<?php

namespace Styde\QueryFilter\Tests\Units;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Styde\QueryFilter\Tests\Models\User;
use Styde\QueryFilter\Tests\TestCase;

class FilterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function applying_query_filters()
    {
        User::query()->create(['name' => 'Luis', 'email' => 'luis@email.com']);
        User::query()->create(['name' => 'Carlos', 'email' => 'carlos@email.com']);
        User::query()->create(['name' => 'Andrés Luis', 'email' => 'LuisAndres@email.com']);

        $this->assertTrue(User::query()->applyFilters(null, ['search' => 'Luis'])->count() == 2);
    }
}
