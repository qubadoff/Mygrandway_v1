<?php

namespace App\Http\Controllers\Api\Drivers;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Driver\UpdateLocationRequest;
use App\Http\Requests\Api\Driver\UpdateRequest;
use App\Models\TruckType;
use App\Support\Api;
use App\Support\Contracts\DriverUser;

class DriverController extends ApiController
{
    public function changeLocation(UpdateLocationRequest $request,DriverUser $driver): Api
    {
        $driver->update([
            'location' => $request->getPoint()
        ]);

        return api()->setMessage('Location updated successfully');
    }

    public function truckTypes(): Api
    {
        return api(TruckType::query()->where('status', 'active')->get())
            ->setMessage('Truck types fetched successfully');
    }

    public function delete(DriverUser $driverUser): Api
    {
        if ($driverUser->hasActiveOrder()) {
            return api()->badRequest()->setMessage('You have active orders');
        }
        $driverUser->tokens()->delete();
        $driverUser->delete();

        return api()->ok();
    }

    public function update(UpdateRequest $request, DriverUser $driver): Api
    {
        $driver->fill($request->validated());

        if ($driver->isDirty('phone')) {

            if ($driver->hasActiveOrder()) {
                return api()->badRequest()->setMessage('You have active orders');
            }

            $driver->phone_verified_at = null;
        }

        $updated = $driver->saveOrFail();

        return api(
            data: $driver,success: $updated
        );
    }

}
