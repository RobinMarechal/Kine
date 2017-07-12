<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model 
{

    protected $table = 'tags';
    public $timestamps = false;
    protected $fillable = array('name');

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function articles()
    {
        return $this->belongsToMany('App\Article');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Course');
    }

}