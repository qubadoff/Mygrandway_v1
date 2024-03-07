<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\Order;
use App\Support\Api;
use App\Support\Contracts\CurrentUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class MessageController extends ApiController
{
    public function index(int $order,CurrentUser $user,Request $request): Api
    {
        $order = $user->orders()->findOrFail($order);

        return api(
            $user
            ->messages()
            ->with(['from:id,full_name','to:id,full_name'])
            ->where('order_id', $order->id)
            ->paginate($request->perPage())
        )->setMessage('Messages fetched successfully');
    }

    public function store(MessageRequest $request,int $order,CurrentUser $user): Api
    {
        /** @var Order $order */
        $order = $user->orders()->findOrFail($order);

        if (!$order->status->inChatting()) {
            return api(success: false)->setCode(400)->setMessage('You can not send message to this order');
        }

        DB::beginTransaction();

        try {

            $toUser = $user->isDriver() ? $order->customer : $order->driver;

            $message = Message::create([
                'order_id' => $order->id,
                'body' => $request->get('body'),
                'to_messageable_id' => $toUser->id,
                'to_messageable_type' => $toUser->getMorphClass(),
            ]);

            DB::commit();

            return api($message->loadMissing(['from:id,full_name','to:id,full_name']))->setMessage('Message sent successfully');
        } catch (Throwable $exception) {

            DB::rollBack();

            return api(success: false)
                ->setCode(500)
                ->setMessage('Something went wrong')
                ->e($exception->getMessage());
        }
    }
}
