<?php


namespace App\Filters;


use Illuminate\Http\Request;

abstract class Filters
{

    protected $request, $builder;
    protected $filters = [];

    /**
     * Apply the filters.
     *
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;
        collect($this->getFilters())
            ->filter(function ($value, $filter) {
                return method_exists($this, $filter);
            })
            ->each(function ($value, $filter) {
                $this->$filter($value);
            });
        return $this->builder;
    }

    public function getFilters()
    {
        $filters = array_intersect(array_keys($this->request->all()), $this->filters);
        return $this->request->only($filters);
    }

}
