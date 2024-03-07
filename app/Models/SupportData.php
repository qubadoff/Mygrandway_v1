<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportData extends Model
{
    use HasFactory;

    protected $table = 'support_data';

    protected $fillable = [
        'email',
        'phone'
    ];

    protected $guarded = [];

    protected $casts = [];
}
