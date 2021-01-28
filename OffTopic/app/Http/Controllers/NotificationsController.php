<?php

namespace App\Http\Controllers;

use App\Notification;
use App\User;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{

    /**
     *  Display a list of all notifications, deleted notifications and not deleted (unreaded) notifications
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index($id)
    {
        if(Auth::id() == $id) {

            $user = User::find($id);

            $allNotifications = $user->notifications()->withTrashed()->orderBy('created_at', 'desc')->get();
            $deletedNotifications = $user->notifications()->onlyTrashed()->orderBy('created_at', 'desc')->get();
            $notDeletedNotifications = $user->notifications()->orderBy('created_at', 'desc')->get();

            return view('notifications.notifications')->with(['allNotifications' => $allNotifications, 'deletedNotifications' => $deletedNotifications, 'notDeletedNotifications' => $notDeletedNotifications]);
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
     * @return mixed
     */
    public static function createNotification(string $type, string $name, string $body, int $user_id, int $sender_id = null)
    {
        $notification = Notification::create([
            'name' => $name,
            'body' => $body,
            'user_id' => $user_id,
            'sender_id' => $sender_id
        ]);

        $lastId = $notification->id;
        return $lastId;
    }

    /**
     *  Hard Deleting specific notification
     *  if there is notification found, we return the notification id
     *  if there is no notification found return -1
     *
     * @param string $type
     * @param string $name
     * @param int $user_id
     * @param int|null $sender_id
     * @return int
     */
    public static function deleteNotificationHard(string $type, string $name, int $user_id, int $sender_id = null)
    {
        if($type == 'FriendRequest' || $type == 'NewFriend') {
            $notification = Notification::where('user_id', $user_id)->where('name', $name)->where('sender_id', $sender_id)->withTrashed()->first();

            if($notification !== null) {
                $notificationId = $notification->id;
                $notification->forceDelete();
                return $notificationId;
            }

            return -1;
        }
    }


    /**
     *  Soft or Hard Deleting specific notification
     *
     * @param $userId
     * @param $notificationId
     * @param $hardOrSoft
     */
    public static function deleteNotificationSoftOrHard($userId, $notificationId, $hardOrSoft)
    {
        if(Auth::check() && $userId == Auth::id()) {
            if($hardOrSoft == 'soft') {
                Notification::where('id', $notificationId)->delete();
            } else {
                Notification::where('id', $notificationId)->forceDelete();
            }
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
     *  Return the count of not deleted notifications for the logged user
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
