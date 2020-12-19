<?php

namespace Styde\QueryFilter\Tests\Units;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Styde\QueryFilter\Tests\Models\User;
use Styde\QueryFilter\Tests\TestCase;

class FilterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function applying_filters_by_name()
    {
        User::create(['name' => 'Luis', 'email' => 'luis@email.com']);
        User::create(['name' => 'Carlos', 'email' => 'carlos@email.com']);
        User::create(['name' => 'Andrés Luis', 'email' => 'LuisAndres@email.com']);

        $this->assertContains(
            'Luis',
            User::query()->applyFilters(null, ['search' => 'Luis'])->get()->pluck('name')->toArray()
        );

        $this->assertNotContains(
            'Carlos',
            User::query()->applyFilters(null, ['search' => 'Luis'])->get()->pluck('name')->toArray()
        );
    }
}
