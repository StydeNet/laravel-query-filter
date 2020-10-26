<?php

namespace Styde\LaravelQueryFilter\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait Sortable
{
    /**
     * Get the format order array
     *
     * @param $order string ColumnName
     * @return array
     */
    public static function info(string $order)
    {
        if (Str::endsWith($order, '-desc')) {
            return [Str::substr($order, 0, -5), 'desc'];
        } else {
            return [$order, 'asc'];
        }
    }

    /**
     * Build url in blade
     *
     * @param $column
     * @return string
     */
    public function sortUrl($column)
    {
        if ($this->isSortingBy($column)) {
            return $this->buildSortableUrl("{$column}-desc");
        }

        return $this->buildSortableUrl($column);
    }

    /**
     * Build Sortable Url
     *
     * @param $order
     * @return string
     */
    protected function buildSortableUrl($order)
    {
        return url()->current() . '?' . Arr::query(array_merge($this->query, ['order' => $order]));
    }

    /**
     * Get css class
     *
     * @param $column
     * @return string
     */
    public function classes($column)
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
     * Validate sorting with a column
     *
     * @param $column
     * @return bool
     */
    protected function isSortingBy($column)
    {
        return Arr::get($this->query, 'order') == $column;
    }
}
