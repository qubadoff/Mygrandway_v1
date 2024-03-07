<?php

namespace App\Models;

use App\Enums\TruckTypeStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TruckType extends Model
{
    use HasFactory;
    use HasTranslations;


    public $translatable = [
        'name',
        'description'
    ];


    protected $table = 'truck_types';


    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
    ];

    protected $casts = [
        'status' =>  TruckTypeStatus::class,
    ];
}
