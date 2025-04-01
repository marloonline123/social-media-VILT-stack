<?php

namespace App\Listeners;

use App\Events\GroupJoinRequested;
use App\Notifications\GroupJoinRequestNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendGroupJoinNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(GroupJoinRequested $event): void
    {
        $admins = $event->group->members()->where('role', 'admin')->get();
        try {
            Notification::send($event->user, new GroupJoinRequestNotification($event->group, $event->user));
            Log::info('Notification sent');
        } catch (\Throwable $th) {
            Log::error('Error sending notification', ['throwable' => $th]);
        }
    }
}
