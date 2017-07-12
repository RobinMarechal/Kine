<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RemovedContent extends Model 
{

    protected $table = 'removed_contents';
    public $timestamps = false;
    protected $fillable = array('name', 'content', 'created_at', 'updated_at', 'user_id', 'removed_at');
    protected $dates = ['removed_at'];

    public function author()
    {
        return $this->belongsTo('App\User');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}