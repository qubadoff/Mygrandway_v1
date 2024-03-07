<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Http\Requests\Api\Customer\OrderRequest;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Order;
use App\Notifications\OrderAcceptedNotification;
use App\Notifications\OrderCompletedNotification;
use App\Support\Api;
use App\Support\Contracts\CurrentUser;
use App\Support\Contracts\CustomerUser;
use App\Support\Contracts\DriverUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderController extends ApiController
{
    public function index(Request $request, OrderStatus $status, CurrentUser $user): Api
    {
        if ($status->isPending() && $user instanceof DriverUser) {

            $builder = $user->getPendingOrders();

            if (!$builder) {
                return api([])->setMessage('No pending orders');
            }

            return $this->indexAction(
                request: $request,
                model: $builder
            );
        }

        return $this->indexAction(
            request: $request,
            model: $user->orders()->where('status', $status->value)
        );
    }

    public function show(int $order, CurrentUser $user): Api
    {
        return api($user->orders()->findOrFail($order))->setMessage('Order fetched successfully');
    }

    public function accept(Order $order, DriverUser $driver): Api
    {
        DB::beginTransaction();

        try {
            if ($order->status->isPending()) {
                $order->forceFill([
                    'status' => OrderStatus::Chatting,
                    'driver_id' => $driver->id,
                ])->save();

                $order->customer->notify(new OrderAcceptedNotification($order));

            } elseif ($order->status->inChatting() && $order->driver_id === $driver->id) {
                $order->forceFill([
                    'status' => OrderStatus::InProgress,
                ])->save();
            } else {
                return api(success: false)->setMessage('Order already taken');
            }

            DB::commit();

            return api($order)->setMessage('Order accepted successfully');

        } catch (Throwable $e) {
            DB::rollBack();

            return api(success: false)->setMessage(
                $e->getMessage() ?: 'Something went wrong, please try again later'
                //'Something went wrong, please try again later'
            )->e($e);
        }
    }


    public function cancel(Request $request, string $order, CustomerUser $user): Api
    {
        $order = $user->orders()->findOrFail($order);

        DB::beginTransaction();

        try {
            if ($order->status->isCancelable()) {
                $order->forceFill([
                    'status' => OrderStatus::Pending,
                    'driver_id' => null,
                ])->save();

                DB::commit();

                return api($order)->setMessage('Order canceled successfully');
            }

            return api(success: false)->setMessage('You can not cancel this order');
        } catch (Throwable $e) {
            DB::rollBack();

            return api(success: false)->setMessage(
                'Something went wrong, please try again later'
            )->e($e);
        }
    }

    public function finish(Request $request, string $order, DriverUser $driver): Api
    {
        /** @var Order $order */
        $order = $driver->orders()->findOrFail($order);

        DB::beginTransaction();

        try {
            if ($order->status->inProgress()) {
                $order->forceFill([
                    'status' => OrderStatus::Completed,
                ])->save();

                $order->customer->notify(new OrderCompletedNotification($order));

                DB::commit();

                return api($order)->setMessage('Order finished successfully');
            }

            return api(success: false)->setMessage('You can not finish this order');
        } catch (Throwable $e) {
            DB::rollBack();

            return api(success: false)->setMessage(
                'Something went wrong, please try again later'
            )->e($e);
        }
    }

    public function store(OrderRequest $request, CustomerUser $customer): Api
    {
        DB::beginTransaction();

        try {
            /** @var Order $order */
            $order = $customer->orders()->create($request->validated());

            DB::commit();

            $drivers = $order->findDrivers();

            return api([
                'order' => $order,
                'message' => 'Order created successfully',
                'found_drivers_count' => $drivers->count(),
            ])->setMessage('Order created successfully');

        } catch (Throwable $e) {

            DB::rollBack();

            return api()->internalServerError()->e($e)->setMessage('Error while creating order');
        }
    }

    public function delete(int $id, CustomerUser $customer)
    {
        /** @var Order $order */
        $order = $customer->orders()->findOrFail($id);

        if (!$order->status->isPending()) {
            return api()->badRequest()->setMessage('You can not delete this order');
        }

        DB::beginTransaction();
        try {
            $order->delete();
            DB::commit();
            return api()->setMessage('Order deleted successfully');
        } catch (Throwable $e) {
            DB::rollBack();
            return api()->internalServerError()->e($e)->setMessage('Error while deleting order');
        }
    }

    public function lookingForDrivers(int $id, CustomerUser $customer): Api
    {
        /** @var Order $order */
        $order = $customer->orders()->findOrFail($id);

        DB::beginTransaction();

        try {
            $drivers = $order->findDrivers();

            DB::commit();

            return api([
                'order' => $order,
                'found_drivers_count' => $drivers->count(),
            ])->setMessage('Drivers found successfully');
        } catch (Throwable $e) {
            DB::rollBack();
            return api()->internalServerError()->e($e)->setMessage('Error while finding drivers');
        }
    }
}
