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
        $checkExistFriendRequest = FriendRequests::where('requested_user_id', $id)->where('sender_user_id', Auth::id())->first();

        if(Auth::id() != $id && $checkExistFriendRequest === null) {
            $user = User::findOrFail($id);

            FriendRequests::create([
                'requested_user_id' => $id,
                'sender_user_id' => Auth::id(),
            ]);
            return response()->json(['success' => "You sent friend request to {$user->name}"]);
        }
        return response()->json(['error' => "You can't send friend request to this user."]);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $friendRequest = FriendRequests::where('requested_user_id', $id)->where('sender_user_id', Auth::id())->first();
        $friendRequest->delete();

        return response()->json(['success' => 'Removed friend request.']);
    }
}
