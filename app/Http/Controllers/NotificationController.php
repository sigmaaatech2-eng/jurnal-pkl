<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function read(
        Request $request,
        string $notification
    ) {
        $user = $request->user();

        $notification = $user
            ->notifications()
            ->where('id', $notification)
            ->firstOrFail();

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return redirect(
            $notification->data['url']
                ?? route('dashboard')
        );
    }
}