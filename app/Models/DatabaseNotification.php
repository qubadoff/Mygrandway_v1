<?php

namespace App\Models;

use App\Components\Eloquent\Concerns\Filterable;

class DatabaseNotification extends \Illuminate\Notifications\DatabaseNotification
{
   use Filterable;

    protected $table = 'notifications';

    protected $hidden = [
        'notifiable_type',
        'notifiable_id',
    ];

    public function getFilters(): array
    {
        return [
            'includes' => [],
            'fields'   => ['id', 'type', 'data', 'read_at', 'created_at', 'updated_at'],
            'sorts'    => ['id', 'type', 'read_at', 'created_at', 'updated_at'],
            'filters'  => ['id', 'type', 'read_at', 'created_at', 'updated_at'],
        ];
    }
}
