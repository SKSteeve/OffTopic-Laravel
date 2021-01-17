<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $table = 'notifications';
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
