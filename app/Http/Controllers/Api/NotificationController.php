<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\NotificationRequest;
use App\Support\Contracts\CurrentUser;
use App\Support\Api;

class NotificationController extends ApiController
{
    public function index(NotificationRequest $request,CurrentUser $currentUser): Api
    {
        return $this->indexAction(
            request: $request,
            model: $currentUser->notifications()
        );
    }

    public function registerFcmToken(NotificationRequest $request,CurrentUser $currentUser): Api
    {
        $currentUser->update([
            'fcm_token' => $request->get('fcm_token')
        ]);

        return api()->setMessage('Fcm token registered successfully');
    }


    public function unregisterFcmToken(NotificationRequest $request,CurrentUser $currentUser): Api
    {
        $currentUser->update([
            'fcm_token' => null
        ]);

        return api()->setMessage('Fcm token unregistered successfully');
    }
}
