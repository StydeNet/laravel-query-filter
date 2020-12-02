<?php

namespace Styde\QueryFilter\Overrides;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Styde\QueryFilter\Concerns\Sortable;

class LengthAwarePaginator extends Paginator
{
    use Sortable;
}
