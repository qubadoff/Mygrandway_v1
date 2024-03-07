<?php

namespace App\Components\Media;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DefaultPathGenerator extends \Spatie\MediaLibrary\Support\PathGenerator\DefaultPathGenerator
{
    protected function getBasePath(Media $media): string
    {
        $prefix = config('media-library.prefix', '');

        $folder = strtolower(class_basename($media->model_type ?? ''));

        if ($prefix !== '') {
            return $prefix . '/' . $folder;
        }

        return $folder;
    }
}
