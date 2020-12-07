<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'users_profiles';
    protected $guarded = ['id'];

    public static $rules = [
        'name' => 'required|alpha|min:3',
        'year' => 'required_with:year,month,date',
        'month' => 'required_with:year,month,date',
        'date' => 'required_with:year,month,date',

        'profile_picture' => 'image|nullable|max:1999'
    ];

    public static $messages = [
        'name.min' => 'Name must be at least 3 characters.',
        'name.alpha' => 'Name must contain only characters.',
        'profile_picture.image' => 'The file must be an image.',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
