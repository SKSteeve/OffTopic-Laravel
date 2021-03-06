<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts() {
        return $this->hasMany('App\Post', 'user_id');
    }

    public function friendList() {
        return $this->hasMany('App\FriendList', 'user_id');
    }

    public function postComments() {
        return $this->hasMany('App\PostComment', 'user_id');
    }

    public function friendRequests() {
        return $this->hasMany('App\FriendRequests', 'requested_user_id');
    }

    public function notifications() {
        return $this->hasMany('App\Notification', 'user_id');
    }

    public function roles() {
        return $this->belongsToMany('App\Role', 'role_user');
    }

    public function profile() {
        return $this->hasOne('App\UserProfile', 'user_id');
    }

    public function hasRoles($roles) {
        if($this->roles()->whereIn('name', $roles)->first()) {
            return true;
        }
        return false;
    }

    public function hasRole($role) {
        if($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }
}
