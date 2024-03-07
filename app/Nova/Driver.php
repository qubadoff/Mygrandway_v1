<?php

namespace App\Nova;

use App\Enums\DriverStatus;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
class Driver extends Resource
{
    public static array $permissions = [
        'view'   => 'Show drivers',
        'create' => 'Create drivers',
        'update' => 'Update drivers',
        'delete' => 'Delete drivers',
    ];

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Driver>
     */
    public static string $model = \App\Models\Driver::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'full_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'full_name',
        'phone',
    ];


    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Full Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Phone')->required(),

            Text::make('Business Code', 'business_code'),

            //text make password secure

            Password::make('Password')->required()->onlyOnForms(),

            Text::make('Fcm Token')->required()->onlyOnPreview(),

            BelongsTo::make('Country')->searchable()->required(),
            BelongsTo::make('City')->searchable()->required(),
            BelongsTo::make('Truck Type', 'truck_type')->searchable()->required(),
            Text::make('Address')->required(),
            Text::make('About')->required(),
            Text::make('License Number', 'driver_license_no')->required(),

            Select::make('Status')->options(DriverStatus::getForNovaDisplay())
                ->displayUsingLabels()
                ->required(),

            DateTime::make( 'Phone Verified At','phone_verified_at')->nullable()->sortable(),
            DateTime::make( 'Created At','created_at')->onlyOnPreview()->sortable(),

            //latitude and longitude
            Text::make('Latitude')->nullable()->onlyOnForms(),
            Text::make('Longitude')->nullable()->onlyOnForms(),

            HasMany::make('Routes','routes', DriverRoute::class)->exceptOnForms(),

            Files::make('Driver License', 'DRIVER_LICENSE')->onlyOnDetail(),
            Files::make('Driver Tex Passport', 'DRIVER_TEX_PASSPORT')->onlyOnDetail(),
            Files::make('Driver Passport', 'DRIVER_PASSPORT')->onlyOnDetail(),
            Files::make('Driver Insurance Doc', 'DRIVER_INSURANCE_DOC')->onlyOnDetail(),
            Files::make('Truck Photo', 'TRUCK_PHOTO')->onlyOnDetail(),
            Files::make('A picture of the trailer', 'TRUCK_PHOTO_TWO')->onlyOnDetail(),
        ];
    }

    public function filters(NovaRequest $request): array
    {
        return [
            new Filters\DriverStatus,
        ];
    }
}
