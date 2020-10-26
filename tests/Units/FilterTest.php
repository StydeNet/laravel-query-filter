<?php

namespace Styde\LaravelQueryFilter\Tests\Units;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Styde\LaravelQueryFilter\Tests\Models\User;
use Styde\LaravelQueryFilter\Tests\TestCase;

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
