<?php

namespace App\Http\Controllers\Api\Customer;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\CustomerUpdateRequest;
use App\Models\Order;
use App\Support\Api;
use App\Support\Contracts\CustomerUser;

class CustomerController extends Controller
{

    public function update(CustomerUpdateRequest $request, CustomerUser $customer)
    {
        $customer->fill($request->validated());

        if ($customer->isDirty('phone')) {
            if ($customer->hasActiveOrders()) {
                return api()->badRequest()->setMessage('You can not change your phone number.Because you have active orders');
            }
            $customer->forceFill([
                'phone_verified_at' => null,
            ]);
        }

        $update = $customer->saveOrFail();

        return api(
            data: $customer,
            success: $update
        );
    }


    public function delete(CustomerUser $customerUser): Api
    {
        if ($customerUser->hasActiveOrders()) {
            return api()->badRequest()->setMessage('You have active orders');
        }

        $customerUser->orders()
            ->where('status', OrderStatus::Pending->value)
            ->get()
            ->each(fn(Order $order) => $order->delete());

        $customerUser->tokens()->delete();

        $customerUser->delete();

        return api()->ok();
    }

    public function getDriverLocation(CustomerUser $customerUser)
    {
        //
    }
}
