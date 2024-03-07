<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\NovaTranslatable\Translatable;

class TruckType extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\TruckType>
     */
    public static $model = \App\Models\TruckType::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
        'description',
        'image',
        'status'
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Translatable::make(
                [
                    Text::make('Name')->required(),
                    Text::make('Description'),
                ]
            ),

            Select::make('Status')->options([
                'active' => 'Active',
                'inactive' => 'Inactive',
            ])->displayUsingLabels()->required(),

        ];
    }
}
