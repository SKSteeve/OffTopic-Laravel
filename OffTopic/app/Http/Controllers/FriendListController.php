<?php

namespace App\Http\Controllers;

use App\FriendList;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FriendListController extends Controller
{
    /**
     *  Return the friends for the logged user sorted alphabetically
     *  Used by ViewServiceProvider which pass the friends to all views
     *  After that we display them in the layout (right sidebar)
     *
     * @return mixed
     */
    public static function getAllFriends()
    {
        $friends = [];

        if(Auth::check()) {
            $friendships = User::findOrFail(Auth::id())->friendList()->get();

            $usersIds = [];

            foreach ($friendships as $friendship) {
                $usersIds[] = $friendship->friend_id;
            }

            $friends = User::whereIn('id', $usersIds)->orderBy('name', 'asc')->get();
        }

        return $friends;
    }


    /**
     *  Accept Friend Request
     *
     *  Delete the Friend Request Notification
     *  Delete the Friend Request
     *  Add two rows in friend_list table with changed positions
     *  Create new notification type NewFriend for both users
     *  get the friends and return them ... to refresh the friend list after accept friend request
     *
     * @param $requestedUserId
     * @param $senderUserId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($requestedUserId, $senderUserId)
    {
        // delete the notification and friend request
        NotificationsController::deleteNotification('FriendRequest', 'Friend Request', $requestedUserId, $senderUserId);
        FriendRequestsController::deleteFriendRequest($requestedUserId, $senderUserId);

        // make new friend ... insert 2 rows with changed positions in friend_list
        FriendList::create([
            'user_id' => $requestedUserId,
            'friend_id' => $senderUserId
        ]);

        FriendList::create([
            'user_id' => $senderUserId,
            'friend_id' => $requestedUserId
        ]);

        // create new notification for both users
        $requestedUser = User::findOrFail($requestedUserId);
        $senderUser = User::findOrFail($senderUserId);

        NotificationsController::createNotification('NewFriend', 'New Friend', "You are now friends with {$senderUser->name}", $requestedUserId, $senderUserId);
        NotificationsController::createNotification('NewFriend', 'New Friend', "You are now friends with {$requestedUser->name}", $senderUserId, $requestedUserId);

        // get the friends and return them ... to refresh the friend list after accept friend request
        $friends = self::getAllFriends();

        return response()->json(['success' => "Successfully created relationship between users {$requestedUser->name} and {$senderUser->name}", 'notification' => "You are now friends with {$senderUser->name}", 'friends' => $friends]);
    }


    /**
     *  Delete "friendship" between two users
     *  Delete notifications for newFriend
     *
     * @param $firstUserId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFriendshipAndNotifications($firstUserId)
    {
        $secondUserId = Auth::id();

        FriendList::where('user_id', $firstUserId)->where('friend_id', $secondUserId)->first()->delete();
        FriendList::where('user_id', $secondUserId)->where('friend_id', $firstUserId)->first()->delete();

        NotificationsController::deleteNotification('NewFriend', 'New Friend', $firstUserId, $secondUserId);
        NotificationsController::deleteNotification('NewFriend', 'New Friend', $secondUserId, $firstUserId);

        $user = User::where('id', $firstUserId)->first();
        $friends = FriendListController::getAllFriends();

        return response()->json(['success' => "You successfully unfriended user {$user->name}", 'friends' => $friends]);
    }


    /**
     *  Delete FriendRequest
     *  Delete Notification type FriendRequest
     *
     * @param $requestedUserId
     * @param $senderUserId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFriendRequestAndNotification($requestedUserId, $senderUserId)
    {
        FriendRequestsController::deleteFriendRequest($requestedUserId, $senderUserId);
        NotificationsController::deleteNotification('FriendRequest', 'Friend Request', $requestedUserId, $senderUserId);

        $notificationsCount = NotificationsController::notificationsCount();

        return response()->json(['success' => 'Deleted friend request and the notification for it.', 'notificationsCount' => $notificationsCount]);
    }


    /**
     *  Check if logged user is friend with given user id
     *
     * @param $friendId
     * @return bool
     */
    public static function checkIfFriends($friendId)
    {
        $friendship = FriendList::where('user_id', Auth::id())->where('friend_id', $friendId)->first();

        if($friendship !== null) {
            return true;
        }

        return false;
    }
}
