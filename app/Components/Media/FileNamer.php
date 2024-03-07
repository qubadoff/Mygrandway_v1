<?php

namespace App\Components\Media;

use Spatie\MediaLibrary\Support\FileNamer\DefaultFileNamer;

class FileNamer extends DefaultFileNamer
{
    public function originalFileName(string $fileName): string
    {
        return md5(time() . parent::originalFileName($fileName));
    }
}
