<?php

namespace App\Components\Media\Driver;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

trait HasDriverPhotos
{
    use InteractsWithMedia;

    public static array $media_request_keys = [
        self::MEDIA_COLLECTIONS['DRIVER_LICENSE'] => 'driver_license_photo',
        self::MEDIA_COLLECTIONS['DRIVER_TEX_PASSPORT'] => 'driver_tex_passport_photo',
        self::MEDIA_COLLECTIONS['DRIVER_PASSPORT'] => 'driver_passport_photo',
        self::MEDIA_COLLECTIONS['DRIVER_INSURANCE_DOC'] => 'driver_insurance_doc_photo',
        self::MEDIA_COLLECTIONS['TRUCK_PHOTO'] => 'truck_photo',
        self::MEDIA_COLLECTIONS['TRUCK_PHOTO_TWO'] => 'truck_photo_two',
    ];

    public function registerMediaCollections(): void
    {
        foreach (static::MEDIA_COLLECTIONS as $collection) {

            if (method_exists($this, $method = Str::studly($collection).'MediaRegister')) {
                $this->{$method}();

                continue;
            }

            $this->addMediaCollection($collection)->singleFile();
        }
    }

    protected function driverLicensePhotoMediaRegister(): void
    {
        $this->addMediaCollection(static::MEDIA_COLLECTIONS['DRIVER_LICENSE'])->onlyKeepLatest(2);
    }

    protected function truckPhotoMediaRegister(): void
    {
        $this->addMediaCollection(static::MEDIA_COLLECTIONS['TRUCK_PHOTO'])->onlyKeepLatest(2);
    }

    protected function truckPhotoTwoMediaRegister(): void
    {
        $this->addMediaCollection(static::MEDIA_COLLECTIONS['TRUCK_PHOTO_TWO'])->onlyKeepLatest(2);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    protected function driverLicensePhotoUpload(Request $request): void
    {
        foreach ($request->file(static::$media_request_keys[static::MEDIA_COLLECTIONS['DRIVER_LICENSE']]) as $file) {
            $this->addMedia($file)->toMediaCollection(static::MEDIA_COLLECTIONS['DRIVER_LICENSE']);
        }
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    protected function truckPhotoUpload(Request $request): void
    {
        foreach ($request->file(static::$media_request_keys[static::MEDIA_COLLECTIONS['TRUCK_PHOTO']]) as $file) {
            $this->addMedia($file)->toMediaCollection(static::MEDIA_COLLECTIONS['TRUCK_PHOTO']);
        }
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    protected function truckPhotoTwoUpload(Request $request): void
    {
        foreach ($request->file(static::$media_request_keys[static::MEDIA_COLLECTIONS['TRUCK_PHOTO_TWO']]) as $file) {
            $this->addMedia($file)->toMediaCollection(static::MEDIA_COLLECTIONS['TRUCK_PHOTO_TWO']);
        }
    }


    public function uploadMediaFromRequest(Request $request): void
    {
        foreach (static::$media_request_keys as $collection => $key) {

            if ($request->hasFile($key)) {

                if(method_exists($this,$method = Str::studly($collection).'Upload')){
                    $this->{$method}($request);

                    continue;
                }

                /** @noinspection PhpUnhandledExceptionInspection */
                $this->addMediaFromRequest($key)->toMediaCollection($collection);
            }
        }
    }
}
