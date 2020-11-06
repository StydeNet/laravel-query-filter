<?php

namespace Styde\QueryFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Styde\QueryFilter\Traits\Sortable;

abstract class AbstractFilter
{
    /**
     * Represents valid data for the filter
     */
    protected $valid = [];

    /**
     * Determines if the model filter uses a dynamic method for undefined queries
     */
    protected $dinamicFilter = false;

    /**
     * Get the validation rules that apply to the request filter.
     *
     * @return array
     */
    protected abstract function rules(): array;

    /**
     * Get the default values for the rules
     *
     * @return array
     */
    protected function valuesDefault(): array
    {
        return [];
    }

    /**
     * Get the valid data for the filter
     *
     * @return mixed
     */
    public function valid()
    {
        return $this->valid;
    }

    /**
     * Apply relations with Join
     *
     * @param Builder $query
     * @return mixed
     */
    protected function applyJoin(Builder $query)
    {
        return $query;
    }

    /**
     * Apply filters to the query
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public function applyTo(Builder $query, array $filters)
    {
        $rules = $this->rules();

        $validator = Validator::make(array_intersect_key($filters, $rules), $rules);

        $this->valid = array_merge($this->valuesDefault(), $validator->valid());

        $this->applyJoin($query);

        foreach ($this->valid as $name => $value) {
            $this->applyFilter($query, $name, $value);
        }

        return $query;
    }

    /**
     * Apply filters by existing method
     *
     * @param Builder $query
     * @param mixed $name
     * @param mixed $value
     */
    protected function applyFilter(Builder $query, $name, $value): void
    {
        if (method_exists($this, $method = Str::camel($name))) {
            $this->$method($query, $value);
        } else {
            if ($this->dinamicFilter) {
                $query->where($name, $value);
            }
        }
    }

    /**
     * Order by column
     *
     * @param Builder $query
     * @param string $value
     */
    public function order(Builder $query, string $value)
    {
        [$column, $direction] = Sortable::info($value);

        $query->orderBy($this->getColumnName($column), $direction);
    }

    /**
     * Get column in aliases array
     *
     * @param $alias
     * @return mixed
     */
    protected function getColumnName($alias)
    {
        return $this->aliases[$alias] ?? $alias;
    }
}
