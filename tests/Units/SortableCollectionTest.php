<?php

namespace Styde\QueryFilter\Tests\Units;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Styde\QueryFilter\Support\Sortable as SortableSupport;
use Styde\QueryFilter\Tests\TestCase;

class SortableCollectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function builds_a_url_with_sortable_data()
    {
        $this->get('http://localhost/demo');

        $sortable = new SortableSupport();

        $this->assertSame(
            'http://localhost/demo?order=name',
            $sortable->sortUrl('name')
        );
    }

    /** @test */
    function appends_query_data_to_the_url()
    {
        $this->get('http://localhost/demo?a=parameter&and=another-parameter');

        $sortable = new SortableSupport();

        $this->assertSame(
            'http://localhost/demo?a=parameter&and=another-parameter&order=name',
            $sortable->sortUrl('name')
        );
    }

    /** @test */
    function builds_a_url_with_desc_order_if_the_current_column_matches_the_given_one_and_the_current_direction_is_asc()
    {
        $this->get('http://localhost/demo?order=name');

        $sortable = new SortableSupport();

        $this->assertSame(
            'http://localhost/demo?order=name-desc',
            $sortable->sortUrl('name')
        );
    }

    /** @test */
    function returns_a_css_class_to_indicate_the_column_is_sortable()
    {
        $sortable = new SortableSupport();

        $this->assertSame('fas fa-sort', $sortable->classes('name'));
    }

    /** @test */
    function returns_css_classes_to_indicate_the_column_is_sorted_in_ascendent_order()
    {
        $this->get('http://localhost/demo?order=name');

        $sortable = new SortableSupport();

        $this->assertSame('fas fa-sort-up', $sortable->classes('name'));
    }

    /** @test */
    function returns_css_classes_to_indicate_the_column_is_sorted_in_descendent_order()
    {
        $this->get('http://localhost/demo?order=name-desc');

        $sortable = new SortableSupport();

        $this->assertSame('fas fa-sort-down', $sortable->classes('name'));
    }
}
