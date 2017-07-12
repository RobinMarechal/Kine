<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{

    protected $table = 'news';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at', 'published_at'];
    protected $fillable = ['created_at', 'updated_at', 'user_id', 'title', 'content', 'published_at', 'views'];


    public function author ()
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


    public function scopePublished ($query)
    {
        return $query->where('published_at', '<=', Carbon::now()
                                                         ->format("Y-m-d H:i:s"));
    }
}