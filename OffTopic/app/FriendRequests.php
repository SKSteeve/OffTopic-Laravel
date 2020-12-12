<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FriendRequests extends Model
{
    protected $table = 'friend_requests';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'requested_user_id');
    }
}
