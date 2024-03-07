<?php

namespace App\Models;

use App\Components\Eloquent\Concerns\Filterable;
use App\Components\Eloquent\Model;
use App\Enums\OrderStatus;
use App\Notifications\NewOrderNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use MatanYadaev\EloquentSpatial\Objects\Point;

/**
 * @property City $from_city
 * @property City $to_city
 * @property int $to_city_id
 * @property int $from_city_id
 * @property int $truck_type_id
 * @property OrderStatus $status
 * @property ?int $driver_id
 * @property Customer $customer
 * @property ?Driver $driver
 * @property int $customer_id
 */
class Order extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = "orders";

    protected $fillable = [
        'customer_id',
        'driver_id',
        'truck_type_id',
        'from_city_id',
        'to_city_id',
        'pickup_at',
        'dropoff_at',
        'rating',
        'comment',
        'meta',
        'price',
        'currency_id'
    ];

    protected $attributes = [
        'status' => OrderStatus::Pending,
    ];


    protected $casts = [
        'status' => OrderStatus::class,
        'pickup_at' => 'datetime',
        'dropoff_at' => 'integer',
    ];

    protected $appends = [
        'distance',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (Order $order) {
            if ($order->wasChanged('driver_id')) {
                $order->messages()->whereNull('deleted_at')->update(['deleted_at' => now()]);
            }
        });

        static::deleted(function (Order $order) {
            $order->notifications()->delete();
        });
    }

    public function getFilters(): array
    {
        return [
            'fields' => [],
            'filters' => [
                'status',
                'pickup_at',
                'dropoff_at',
            ],
            'sorts' => [],
            'includes' => [
                'from_city',
                'to_city',
                'truck_type',
                'customer',
                'driver',
            ],
        ];
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'order_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(DatabaseNotification::class, 'order_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(CurrencyType::class, 'currency_id', 'id');
    }

    public function from_city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'from_city_id');
    }

    public function to_city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'to_city_id');
    }

    public function truckType(): BelongsTo
    {
        return $this->belongsTo(TruckType::class, 'truck_type_id');
    }

    public function getEndLocationPoint(): Point
    {
        return new Point($this->to_city->latitude, $this->to_city->longitude);
    }

    /**
     * @return Collection<Driver>
     */
    public function findDrivers(): Collection
    {
        if (!$this->status->isPending()) {
            abort(400, 'Order status is not pending');
        }

        $result = RateLimiter::attempt(
            key: 'find-drivers:' . $this->id,
            maxAttempts: 60,
            callback: function () {
                $finder = fn(int $radius = 10) => Driver::findNearestDistance(
                    point: $this->getStartLocationPoint(),
                    radius: $radius,
                    extraQuery: function ($query) {
                        $query
                            ->whereNotNull('fcm_token')
                            ->where('truck_type_id', $this->truck_type_id)
                            ->doesntHave(relation:'notifications',callback: function ($query){
                                $query->where('order_id',$this->id);
                            })
                            ->whereHas('routes', function ($query) {
                                $query->where(function ($query) {
                                    $query->where(function ($query) {
                                        $query->where('from_city_id', $this->from_city_id)->where('to_city_id', $this->to_city_id);
                                    })
                                   ->orWhere(function ($query) {
                                        $query->where('from_city_id', $this->to_city_id)->where('to_city_id', $this->from_city_id);
                                    });
                                });
                            })
                        ;
                    }
                );

                foreach (range(1, 20, 2) as $i) {
                    $drivers = $finder($i * 10);
                    if ($drivers->isNotEmpty()) {
                        break;
                    }
                }

                Notification::send($drivers, new NewOrderNotification($this));

                return $drivers;
            },
            decaySeconds: 60
        );

        if (!$result) {
            abort(429, 'Too many driver requests.You can try again after 1 minute.');
        }

        return $result;
    }

    public function getStartLocationPoint(): Point
    {
        return new Point($this->from_city->latitude, $this->from_city->longitude);
    }

    public function getDistanceAttribute(): ?float
    {
        if(
            !isset($this->original['distance']) &&
            $this->relationLoaded('from_city') &&
            $this->relationLoaded('to_city')
        ){
            return getDistanceBetweenTwoPoints(
                point1: $this->getStartLocationPoint(),
                point2: $this->getEndLocationPoint(),
            );
        }

        if(!isset($this->original['distance'])){
            return null;
        }

        return (float)$this->original['distance'];
    }

    public function getConversationKeyAttribute(): string
    {
        return md5($this->id."c:".$this->customer_id."d:".$this->driver_id);
    }
}
