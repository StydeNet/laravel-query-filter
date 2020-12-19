<?php

namespace Styde\QueryFilter\Support;

use Illuminate\Support\Str;
use \Styde\QueryFilter\Concerns\Sortable as SortableConcern;
use \Styde\QueryFilter\Contracts\Sortable as SortableContract;

class Sortable implements SortableContract
{
    use SortableConcern;

    /**
     * Sortable constructor.
     */
    public function __construct()
    {
        $this->query = request()->query();
    }

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
}
