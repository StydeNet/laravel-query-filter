<?php

namespace Styde\QueryFilter\Concerns;

use Illuminate\Support\Arr;

trait Sortable
{
    /**
     * Build URL in blade
     *
     * @param string $column
     * @return string
     */
    public function sortUrl(string $column): string
    {
        if ($this->isSortingBy($column)) {
            return $this->buildSortableUrl("{$column}-desc");
        }

        return $this->buildSortableUrl($column);
    }

    /**
     * Get CSS class
     *
     * @param string $column
     * @return string
     */
    public function classes(string $column): string
    {
        if ($this->isSortingBy($column)) {
            return config('query-filter.icons.up');
        }

        if ($this->isSortingBy("{$column}-desc")) {
            return config('query-filter.icons.down');
        }

        return config('query-filter.icons.sort');
    }

    /**
     * Build Sortable Url
     *
     * @param $order
     * @return string
     */
    protected function buildSortableUrl($order)
    {
        return url()->current().'?'.Arr::query(array_merge($this->query, ['order' => $order]));
    }

    /**
     * Validate sorting with a column
     *
     * @param $column
     * @return bool
     */
    protected function isSortingBy($column)
    {
        return Arr::get($this->query, 'order') === $column;
    }
}
