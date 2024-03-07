<?php

namespace App\Components\Eloquent\Concerns;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder as Filter;

trait Filterable
{
    private static array $filters = [
        'includes' => [],
        'fields'   => [],
        'sorts'    => [],
        'filters'  => []
    ];


    public function asFilter(array $filters = [], Request $request = null,$builder = null): Filter
    {
        return $this->filterBuilderChainMethods($this->getFilter($request,$builder), $filters);
    }


    private function filterBuilderChainMethods(Filter $filter, $filters = []): Filter
    {
        $filters = array_merge($this->getFilters(), $filters);

        return $filter->allowedFields($filters['fields'] ?? [])
            ->allowedIncludes($filters['includes'] ?? [])
            ->allowedFilters($filters['filters'] ?? [])
            ->allowedSorts($filters['sorts'] ?? []);
    }

    public function getFilter($request = null, $builder = null): Filter
    {
        return Filter::for($builder ?? $this, $this->createRequestForFilters($request));
    }

    protected function createRequestForFilters($request = null)
    {
        return $request ?? app(Request::class);
    }

    public function scopeFilter($builder, $filters = []): Filter
    {
        return $this->filterBuilderChainMethods($this->getFilter(null, $builder), $filters);
    }


    public function getPassedIncludes($request): array
    {
        return array_intersect(
            explode(',',$request->get('include', '')),
            $this->getFilters()['includes'] ?? [],
        );
    }

    public function getFilters(): array
    {
        return self::$filters;
    }

}
