<?php

namespace Styde\LaravelQueryFilter\Overrides;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Styde\LaravelQueryFilter\Traits\Sortable;

class LengthAwarePaginator extends Paginator
{
    use Sortable;
}
