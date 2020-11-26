<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $table = 'posts_comments';
    protected $guarded = ['id'];

    public static $rules = [
        'body' => 'required|min:15'
    ];

    public static $messages = [
        'body.min' => 'Body must have at least 15 characters.',
    ];

    public function getRegisteredAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function post() {
        return $this->belongsTo('App\Post', 'post_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
