<?php

namespace App\Http\Controllers;

use App\Notification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{

    /**
     *  Display a list of all notifications
     *
     * @param $id
     */
    public function index($id)
    {
        if(Auth::id() == $id) {

            $user = User::find($id);
            $notifications = $user->notifications()->orderBy('created_at', 'desc')->get();

            return view('notifications.notifications')->with(['notifications' => $notifications]);
        }

        return redirect("/users/profile/$id")->with('error', 'Access denied.');
    }

    /**
     *  Creating new Notification for user
     *
     * @param string $type
     * @param string $name
     * @param string $body
     * @param int $user_id
     * @param int|null $sender_id
     */
    public static function createNotification(string $type, string $name, string $body, int $user_id, int $sender_id = null):void
    {
        if($type == 'FriendRequest' || $type == 'NewFriend') {
            Notification::create([
                'name' => $name,
                'body' => $body,
                'user_id' => $user_id,
                'sender_id' => $sender_id
            ]);
        }
    }

    /**
     *  Delete specific notification
     *
     * @param string $type
     * @param string $name
     * @param int $user_id
     * @param int|null $sender_id
     */
    public static function deleteNotification(string $type, string $name, int $user_id, int $sender_id = null)
    {
        if($type == 'FriendRequest' || $type == 'NewFriend') {
            Notification::where('user_id', $user_id)->where('name', $name)->where('sender_id', $sender_id)->first()->delete();
        }
    }


    /**
     *  Delete all notifications for given user
     *
     * @param int $user_id
     */
    public static function deleteAllNotifications(int $user_id)
    {
        Notification::where('user_id', $user_id)->delete();
    }


    /**
     *  Return the count of notifications for the logged user
     *
     * @return int
     */
    public static function getNotificationsCount()
    {
        $notifications = Notification::where('user_id', Auth::id())->get();
        $notificationsCount = count($notifications);

        return $notificationsCount;
    }
}
