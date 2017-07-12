<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $table = 'events';
    public $timestamps = true;
    protected $fillable = ['created_at', 'updated_at', 'name', 'description', 'article_id', 'user_id', 'views'];
    protected $dates = ['deleted_at', 'date'];


    public function article ()
    {
        return $this->belongsTo('App\Article');
    }


    public function creator ()
    {
        return $this->belongsTo('App\User');
    }


    public function user ()
    {
        return $this->belongsTo('App\User');
    }


    public function medias ()
    {
        return $this->morphMany('App\Media');
    }

}