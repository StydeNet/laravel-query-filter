<?php

namespace Styde\QueryFilter\Overrides;

use \Styde\QueryFilter\Contracts\Sortable as SortableContract;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Styde\QueryFilter\Concerns\Sortable;

class LengthAwarePaginator extends Paginator implements SortableContract
{
    use Sortable;
}
