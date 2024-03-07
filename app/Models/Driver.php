<?php

namespace App\Models;

use App\Components\Eloquent\Authenticatable;
use App\Components\Eloquent\Concerns\CanResetPassword;
use App\Components\Eloquent\Concerns\DriverHasLocation;
use App\Components\Eloquent\Concerns\DriverHasRoutes;
use App\Components\Eloquent\Concerns\Filterable;
use App\Components\Eloquent\Concerns\HasMessage;
use App\Components\Eloquent\Concerns\HasVerifyPhone;
use App\Components\Eloquent\Contracts\MustVerifyPhone;
use App\Components\Media\Driver\HasDriverPhotos;
use App\Enums\DriverStatus;
use App\Enums\OrderStatus;
use App\Support\Contracts\CurrentUser;
use App\Support\Contracts\DriverUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\SpatialBuilder;
use Spatie\MediaLibrary\HasMedia;

/**
 * @property ?string $fcm_token
 * @property float|mixed $latitude
 * @property float|mixed $longitude
 * @property Collection<int,Media> $media
 * @method  static static active()
 */
class Driver extends Authenticatable implements HasMedia, MustVerifyPhone,CurrentUser,DriverUser
{
    use HasVerifyPhone;
    use SoftDeletes;
    use HasFactory;
    use Notifiable;
    use HasDriverPhotos;
    use DriverHasRoutes;
    use DriverHasLocation;
    use HasMessage;
    use Filterable;
    use CanResetPassword;

    public const MEDIA_COLLECTIONS = [
        'DRIVER_LICENSE' => 'DRIVER_LICENSE',
        'DRIVER_TEX_PASSPORT' => 'DRIVER_TEX_PASSPORT',
        'DRIVER_PASSPORT' => 'DRIVER_PASSPORT',
        'DRIVER_INSURANCE_DOC' => 'DRIVER_INSURANCE_DOC',
        'TRUCK_PHOTO' => 'TRUCK_PHOTO',
        'TRUCK_PHOTO_TWO' => 'TRUCK_PHOTO_TWO'
    ];


    protected $table = "drivers";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'phone',
        'password',
        'country_id',
        'city_id',
        'address',
        'about',
        'location',
        'latitude',
        'longitude',
        'driver_license_no',
        'truck_type_id',
        'fcm_token',
        'routes',
        'business_code'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'phone_verified_at',
        'fcm_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'phone_verified_at' => 'datetime',
        'status' => DriverStatus::class,
    ];

    protected $appends = [
        'is_verified',
    ];

    public static function query(): SpatialBuilder
    {
        return parent::query();
    }

    public function getFilters(): array
    {
        return [
            'fields' => [],
            'filters' => [],
            'sorts' => [],
            'includes' => [
                'truck_type',
                'country',
                'city',
            ],
        ];
    }

    public function routeNotificationForFcm(): ?string
    {
        return $this->fcm_token;
    }

    public function scopeActive($query)
    {
        return $query->where('status', DriverStatus::APPROVED);
    }

    public function activeOrders(): HasMany
    {
        return $this->orders()->whereIn('status', OrderStatus::getActiveList());
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function truck_type(): BelongsTo
    {
        return $this->belongsTo(TruckType::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->latest();
    }


    public function toArray(): array
    {
        if ($this->relationLoaded('media')) {
            $media = [];

            foreach (self::MEDIA_COLLECTIONS as $key => $collection) {
                $media[static::$media_request_keys[$key]] = $this->media->filter(function ($media) use ($collection) {
                    return $media->collection_name === $collection;
                })->map(function ($media) {
                    return [
                        'url' => $media->getFullUrl(),
                        'name' => $media->file_name,
                        'mime_type' => $media->mime_type,
                        'size' => $media->size,
                    ];
                })->values()->toArray();
            }

            $this->unsetRelation('media');

            $this->attributes['media'] = $media;
        }

        return parent::toArray();
    }

    public function hasActiveOrder(): bool
    {
        return $this->activeOrders()->exists();
    }
}
