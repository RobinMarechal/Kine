<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{

    protected $table = 'courses';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['created_at', 'updated_at', 'article_id', 'description', 'views', 'name'];
	public $temporalField = 'created_at';


    public function clients ()
    {
        return $this->belongsToMany('App\User');
    }

	public function users ()
	{
		return $this->clients();
	}


    public function doctors ()
    {
        return $this->belongsToMany('App\User', 'course_doctor');
    }


    public function courses ()
    {
        return $this->belongsToMany('App\Tag');
    }


    public function medias ()
    {
        return $this->morphMany('App\Media');
    }


	public function tags ()
	{
		return $this->belongsToMany('App\Tag');
    }

}