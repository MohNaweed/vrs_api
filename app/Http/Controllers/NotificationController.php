<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class NotificationController extends Controller
{
    public function notifications(){
        $user = User::find(auth()->id());
        $notifications = $user->notifications;
        $unreadNotificationCount = $user->unreadNotifications->count();

        return [$notifications,$unreadNotificationCount];
    }
    public function unreadNotifications(){
        return User::find(auth()->id())->unreadNotifications;
    }
    public function readNotifications(){
        return User::find(auth()->id())->readNotifications;
    }
    public function markAsReadNotifications(){
        return User::find(auth()->id())->unreadNotifications->markAsRead();
    }
    public function destroyNotifications(){
        return User::find(auth()->id())->notifications->delete();
    }
}
