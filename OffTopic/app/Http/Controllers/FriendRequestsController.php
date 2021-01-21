<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\FriendRequests;
use Illuminate\Support\Facades\Auth;

class FriendRequestsController extends Controller
{
    /**
     *  Store friend request
     *
     * @param $id
     */
    public function store($id)
    {
        $checkFriendRequestFromSenderUser = FriendRequests::where('requested_user_id', $id)->where('sender_user_id', Auth::id())->first();
        $checkFriendRequestFromRequestedUser = FriendRequests::where('requested_user_id', Auth::id())->where('sender_user_id', $id)->first();

        if(Auth::id() != $id && $checkFriendRequestFromSenderUser === null) {

            // check if their is existing request from the requested_user to the sender user ... if so they are automatically friends
            if($checkFriendRequestFromRequestedUser) {
                $friendShip = new FriendListController();
                $friendShip->store(Auth::id(), $id);
                $requestedUser = User::findOrFail($id);

                return response()->json(['newFriend' => "You are now friends with {$requestedUser->name}"]);
            }

            FriendRequests::create([
                'requested_user_id' => $id,
                'sender_user_id' => Auth::id(),
            ]);

            $requestedUser = User::findOrFail($id);
            $senderUser = User::findOrFail(Auth::id());

            NotificationsController::createNotification('FriendRequest', 'Friend Request', "You received new friend request from {$senderUser->name}", $id, Auth::id());
            return response()->json(['success' => "You sent friend request to {$requestedUser->name}"]);
        }
        return response()->json(['error' => "You can't send friend request to this user."]);
    }



    /**
     *  The sender Delete the friend request he sent ON RECEIVER PROFILE
     *  The notification that receiver had is also deleted.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $friendRequest = FriendRequests::where('requested_user_id', $id)->where('sender_user_id', Auth::id())->first();
        $friendRequest->delete();

        NotificationsController::deleteNotificationHard('FriendRequest', 'Friend Request', $id, Auth::id());

        return response()->json(['success' => 'Removed friend request.']);
    }


    /**
     *  The reciever/requested user, Delete friend request ON HIS NOTIFICATIONS
     *
     * @param $requestedUserId
     * @param $senderUserId
     */
    public static function deleteFriendRequest($requestedUserId, $senderUserId)
    {
        $friendRequest = FriendRequests::where('requested_user_id', $requestedUserId)->where('sender_user_id', $senderUserId)->first();
        $friendRequest->delete();
    }


    /**
     *  Check if friend request exist
     *
     * @param $requestedUserId
     * @param $senderUserId
     * @return bool
     */
    public static function checkIfRequestExist($requestedUserId, $senderUserId)
    {
        $friendRequest = FriendRequests::where('requested_user_id', $requestedUserId)->where('sender_user_id', $senderUserId)->first();

        if($friendRequest !== null) {
            return true;
        }
        return false;
    }
}
