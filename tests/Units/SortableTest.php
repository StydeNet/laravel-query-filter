<?php

namespace Styde\QueryFilter\Tests\Units;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Styde\QueryFilter\Overrides\LengthAwarePaginator;
use Styde\QueryFilter\Tests\Models\User;
use Styde\QueryFilter\Tests\TestCase;
use Styde\QueryFilter\Concerns\Sortable;

class SortableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function gets_the_info_about_the_column_name_and_the_order_direction()
    {
        $this->assertSame(['name', 'asc'], Sortable::info('name'));
        $this->assertSame(['name', 'desc'], Sortable::info('name-desc'));
        $this->assertSame(['email', 'asc'], Sortable::info('email'));
        $this->assertSame(['email', 'desc'], Sortable::info('email-desc'));
    }
}
