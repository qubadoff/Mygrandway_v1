<?php

namespace App\Models;

class Media extends \Spatie\MediaLibrary\MediaCollections\Models\Media
{
    protected $hidden = [
        'id',
        'model_type',
        'model_id',
        'conversions_disk',
        'disk',
        'manipulations',
        'generated_conversions',
        'preview_url',
        'custom_properties',
        'responsive_images',
        'order_column',
        'created_at',
        'updated_at',
    ];
}
