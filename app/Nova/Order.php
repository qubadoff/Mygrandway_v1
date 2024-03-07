<?php

namespace App\Nova;

use App\Enums\OrderStatus;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Order extends Resource
{

    public static array $permissions = [
        'view'   => 'Show orders',
        'create' => 'Create orders',
        'update' => 'Update orders',
        'delete' => 'Delete orders',
    ];

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Admin>
     */
    public static $model = \App\Models\Order::class;

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
    ];

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Customer', 'customer', Customer::class),

            BelongsTo::make('Driver', 'driver', Driver::class)->nullable(),

            BelongsTo::make('Truck Type', 'truckType', TruckType::class),

            BelongsTo::make('From City', 'from_city', City::class)->searchable(),

            BelongsTo::make('To City', 'to_city', City::class)->searchable(),

            DateTime::make('Pickup At')->sortable(),

            Number::make('Dropoff At')->sortable()->nullable(),

            Number::make('Rating')->nullable()->min(0)->max(5)->step(1),

            Textarea::make('Comment')->nullable(),

            Currency::make('Price')->nullable(),

            BelongsTo::make('Currency', 'currency', CurrencyType::class),

            Select::make('Status')->options(
                OrderStatus::toSelectOptions()
            )->displayUsingLabels(),

            Text::make('Distance','distance')->onlyOnDetail(),
        ];
    }


    public static function label(): string
    {
        return 'Orders';
    }

    public static function singularLabel(): string
    {
        return 'Order';
    }

    public function filters(NovaRequest $request): array
    {
        return [
            new Filters\OrderStatus,
        ];
    }
}
