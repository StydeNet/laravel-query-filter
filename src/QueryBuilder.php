<?php

namespace Styde\QueryFilter;

use BadMethodCallException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class QueryBuilder extends Builder
{
    /**
     * @var AbstractFilter
     */
    private $filters;

    /**
     * Apply filters in the model query
     *
     * @param AbstractFilter|null $filter
     * @param array|null $data
     * @return Builder
     */
    public function applyFilters(AbstractFilter $filter = null, array $data = null)
    {
        return $this->filterBy($filter ?: $this->newQueryFilter(), $data ?: request()->all());
    }

    /**
     * Returns the filter instance to apply
     *
     * @return mixed
     */
    protected function newQueryFilter()
    {
        if (method_exists($this->model, 'newQueryFilter')) {
            return $this->model->newQueryFilter();
        }

        if (class_exists($filterClass = 'App\Filters\\' . class_basename($this->model) . 'Filter')) {
            return new $filterClass;
        }

        throw new BadMethodCallException(
            sprintf('No query filter was found for the model [%s]', get_class($this->model))
        );
    }

    /**
     * Apply advanced filters to the model
     *
     * @param array $data
     * @param AbstractFilter $filters
     * @return Builder
     */
    public function filterBy(AbstractFilter $filters, array $data)
    {
        $this->filters = $filters;

        return $filters->applyTo($this, $data);
    }

    /**
     * Paginate the given query.
     *
     * @param int|null $perPage
     * @param array $columns
     * @param string $pageName
     * @param int|null $page
     * @return LengthAwarePaginator
     *
     * @throws InvalidArgumentException
     */
    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $paginator = parent::paginate($perPage, $columns, $pageName, $page);

        if ($this->filters) {
            $paginator->appends($this->filters->valid());
        }

        return $paginator;
    }

    /**
     * Get records trashed based on a condition
     *
     * @param $value
     * @return $this
     */
    public function onlyTrashedIf($value)
    {
        if ($value) {
            $this->onlyTrashed();
        }

        return $this;
    }

    /**
     * Allows a custom query in SQL format
     *
     * @param $subquery
     * @param $operator
     * @param null $value
     * @return $this
     */
    public function whereQuery($subquery, $operator, $value = null)
    {
        $this->addBinding($subquery->getBindings());
        $this->where(DB::raw("({$subquery->toSql()})"), $operator, $value);

        return $this;
    }
}
