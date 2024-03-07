<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyType extends Model
{
    use HasFactory;

    protected $table = 'currency_types';

    protected $fillable = [
        'name'
    ];

    protected $guarded = [];

    protected $casts = [];
}
