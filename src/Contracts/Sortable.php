<?php

namespace Styde\QueryFilter\Contracts;

interface Sortable
{
    /**
     * Build url in blade
     *
     * @param string $column
     * @return string
     */
    public function sortUrl(string $column): string;

    /**
     * Get css class
     *
     * @param string $column
     * @return string
     */
    public function classes(string $column): string;
}
