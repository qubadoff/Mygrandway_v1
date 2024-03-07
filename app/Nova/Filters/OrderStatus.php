<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class OrderStatus extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @var string
     */
    public $name = 'Status';

    /**
     * Apply the filter to the given query.
     *
     * @param NovaRequest $request
     * @param  Builder|Relation  $query
     * @param  mixed  $value
     * @return Builder|Relation
     */
    public function apply(NovaRequest $request, $query, $value): Relation|Builder
    {
        return $query->where('status', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param NovaRequest $request
     * @return array<string, string>
     */
    public function options(NovaRequest $request): array
    {
        return array_flip(\App\Enums\OrderStatus::toSelectOptions());
    }
}
