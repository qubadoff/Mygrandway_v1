<?php

namespace App\Models;

use App\Components\Eloquent\Model;
use App\Notifications\MessageNotification;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int|mixed|string|null $from_messageable_id
 * @property mixed $from_messageable_type
 * @property Customer|Driver $to
 * @property string $body
 * @property bool $is_sender
 * @property string $group
 * @property string $to_messageable_type
 * @property int $to_messageable_id
 * @property string $order_id
 */
class Message extends Model
{
    use SoftDeletes;
    use HasFactory,HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    public const CHANNEL = 'message';

    protected $table = 'messages';

    protected $fillable = [
        'from_messageable_id',
        'from_messageable_type',
        'to_messageable_id',
        'to_messageable_type',
        'order_id',
        'body',
        'read_at',
    ];


    protected $hidden = [
        'from_messageable_id',
        'from_messageable_type',
        'to_messageable_id',
        'to_messageable_type',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    protected $appends = [
        'is_sender',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Message $message) {
            $message->from_messageable_id = auth()?->id();
            $message->from_messageable_type = auth()?->user()?->getMorphClass();

            $message->forceFill(['group' => $message->generateGroupKey()]);
        });

        static::created(function (Message $message) {
            $message->to->notify(new MessageNotification($message));
        });
    }

    public function from(): MorphTo
    {
        return $this->morphTo('from','from_messageable_type','from_messageable_id');
    }

    public function to(): MorphTo
    {
        return $this->morphTo('to','to_messageable_type','to_messageable_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getIsSenderAttribute(): bool
    {
        return $this->from_messageable_id === auth()?->id()
            && $this->from_messageable_type === auth()?->user()?->getMorphClass();
    }

    public function read(): void
    {
        $this->update(['read_at' => now()]);
    }

    public function generateGroupKey(): string
    {
        $driver_id = null;
        $customer_id = null;
        $driver_type = null;
        $customer_type = null;

        if ($this->from_messageable_type === Driver::class) {
            $driver_id  = $this->from_messageable_id;
            $customer_id = $this->to_messageable_id;
            $driver_type = $this->from_messageable_type;
            $customer_type = $this->to_messageable_type;
        } elseif ($this->to_messageable_type === Driver::class) {
            $driver_id   = $this->to_messageable_id;
            $customer_id = $this->from_messageable_id;
            $driver_type = $this->to_messageable_type;
            $customer_type = $this->from_messageable_type;
        }

        return md5($driver_type.$driver_id.$customer_type.$customer_id.$this->order_id);
    }

}
