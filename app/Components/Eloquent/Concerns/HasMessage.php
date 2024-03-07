<?php

namespace App\Components\Eloquent\Concerns;

use App\Models\Message;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasMessage
{
    public function messages(): Builder
    {
        return Message::query()
            ->where(function (Builder $query) {
                $query->where(function($q) {
                    $q->where('from_messageable_id', $this->id)
                        ->where('from_messageable_type', $this->getMorphClass());
                })
                    ->orWhere(function($q) {
                        $q->where('to_messageable_id', $this->id)
                            ->where('to_messageable_type', $this->getMorphClass());
                    });
            });
    }

    public function unreadMessages(): Builder
    {
        return $this->messages()->whereNull('read_at');
    }

    public function readMessages(): Builder
    {
        return $this->messages()->whereNotNull('read_at');
    }


    public function toMessage(): MorphMany
    {
        return $this->morphMany(Message::class,'to_messageable');
    }

    public function fromMessage(): MorphMany
    {
        return $this->morphMany(Message::class,'from_messageable');
    }
}
