<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $guarded = ['id'];

    public static $rules = [
        'title' => 'required|min:4|max:100',
        'body' => 'required|min:15'
    ];

    public static $messages = [
        'title.min' => 'Title must be at least 4 characters.',
        'title.max' => "Title must contain less then 100 characters.",
        'body.min' => 'Body must have at least 15 characters.',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function comments() {
        return $this->hasMany('App\PostComment', 'post_id');
    }
}
