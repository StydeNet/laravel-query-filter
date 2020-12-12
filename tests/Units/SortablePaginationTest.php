<?php

namespace Styde\QueryFilter\Tests\Units;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Styde\QueryFilter\Tests\Models\User;
use Styde\QueryFilter\Tests\TestCase;

class SortablePaginationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function builds_a_url_with_sortable_data()
    {
        $this->get('http://localhost/demo');

        $users = User::paginate(5);

        $this->assertSame(
            'http://localhost/demo?order=name',
            $users->sortUrl('name')
        );
    }

    /** @test */
    function appends_query_data_to_the_url()
    {
        $this->get('http://localhost/demo?a=parameter&and=another-parameter');

        $users = User::paginate()->appends([
            'a' => 'parameter',
            'and' => 'another-parameter',
        ]);

        $this->assertSame(
            'http://localhost/demo?a=parameter&and=another-parameter&order=name',
            $users->sortUrl('name')
        );
    }

    /** @test */
    function builds_a_url_with_desc_order_if_the_current_column_matches_the_given_one_and_the_current_direction_is_asc()
    {
        $this->get('http://localhost/demo?order=name');

        $users = User::paginate()->appends([
            'order' => 'name'
        ]);

        $this->assertSame(
            'http://localhost/demo?order=name-desc',
            $users->sortUrl('name')
        );
    }

    /** @test */
    function returns_a_css_class_to_indicate_the_column_is_sortable()
    {
        $users = User::paginate();

        $this->assertSame('fas fa-sort', $users->classes('name'));
    }

    /** @test */
    function returns_css_classes_to_indicate_the_column_is_sorted_in_ascendent_order()
    {
        $this->get('http://localhost/demo?order=name');

        $users = User::paginate()->appends([
            'order' => 'name'
        ]);

        $this->assertSame('fas fa-sort-up', $users->classes('name'));
    }

    /** @test */
    function returns_css_classes_to_indicate_the_column_is_sorted_in_descendent_order()
    {
        $this->get('http://localhost/demo?order=name-desc');

        $users = User::paginate()->appends([
            'order' => 'name-desc'
        ]);

        $this->assertSame('fas fa-sort-down', $users->classes('name'));
    }
}
