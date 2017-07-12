<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model 
{

    protected $table = 'contents';
    public $timestamps = true;
    protected $fillable = array('name', 'title', 'content', 'updated_at', 'user_id');

    public function author()
    {
        return $this->belongsTo('App\User');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}