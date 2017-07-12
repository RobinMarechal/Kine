<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model 
{

    protected $table = 'notifications';
    public $timestamps = false;
    protected $fillable = array('created_at', 'updated_at', 'user_id', 'notifiable_id', 'notifiable_type', 'seen_at', 'content', 'link');

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}