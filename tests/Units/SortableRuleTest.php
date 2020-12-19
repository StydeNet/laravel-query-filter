<?php

namespace Styde\QueryFilter\Tests\Units;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Styde\QueryFilter\Rules\SortableColumn;
use Styde\QueryFilter\Tests\TestCase;
use Styde\QueryFilter\Support\Sortable;

class SortableRuleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function validates_sortable_values()
    {
        $rule = new SortableColumn(['id', 'name', 'email']);

        $this->assertTrue($rule->passes('order', 'id'));
        $this->assertTrue($rule->passes('order', 'name'));
        $this->assertTrue($rule->passes('order', 'email'));
        $this->assertTrue($rule->passes('order', 'id-desc'));
        $this->assertTrue($rule->passes('order', 'name-desc'));
        $this->assertTrue($rule->passes('order', 'email-desc'));

        $this->assertFalse($rule->passes('order', []));
        $this->assertFalse($rule->passes('order', 'first_name'));
        $this->assertFalse($rule->passes('order', 'name-descendent'));
        $this->assertFalse($rule->passes('order', 'asc-name'));
        $this->assertFalse($rule->passes('order', 'email-'));
        $this->assertFalse($rule->passes('order', 'email-des'));
        $this->assertFalse($rule->passes('order', 'name-descx'));
        $this->assertFalse($rule->passes('order', 'desc-name'));
    }

    /** @test */
    function gets_the_info_about_the_column_name_and_the_order_direction()
    {
        $this->assertSame(['name', 'asc'], Sortable::info('name'));
        $this->assertSame(['name', 'desc'], Sortable::info('name-desc'));
        $this->assertSame(['email', 'asc'], Sortable::info('email'));
        $this->assertSame(['email', 'desc'], Sortable::info('email-desc'));
    }
}
