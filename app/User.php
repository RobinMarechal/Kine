<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
	use Notifiable;
	protected $table = 'users';
	public $urlNamespace = 'utilisateurs';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = ['created_at', 'updated_at', 'email', 'name', 'facebook_id', 'password', 'level', 'phone', 'starts_at', 'ends_at', 'is_doctor', 'connections'];
	protected $hidden = ['facebook_id', 'password'];
	public $temporalField = 'created_at';


	public function tags ()
	{
		return $this->belongsToMany('App\Tag');
	}


	public function coursesAsCustomer ()
	{
		return $this->belongsToMany('App\Course');
	}


	public function coursesAsDoctor ()
	{
		return $this->belongsToMany('App\Course', 'course_doctor');
	}


	public function supervisedCourses ()
	{
		return $this->belongsToMany('App\Course', 'course_doctor');
	}


	public function courses ()
	{
		return $this->belongsToMany('App\Course');
	}


	public function logins ()
	{
		return $this->hasMany('App\Login');
	}


	public function contacts ()
	{
		return $this->hasMany('App\Contact');
	}


	public function news ()
	{
		return $this->hasMany('App\News');
	}


	public function articles ()
	{
		return $this->hasMany('App\Article');
	}


	public function contents ()
	{
		return $this->hasMany('App\Content');
	}


	public function removedContents ()
	{
		return $this->hasMany('App\RemovedContent');
	}


	public function medias ()
	{
		return $this->hasMany('App\Media');
	}


	public function notifications ()
	{
		return $this->hasMany('App\Notification');
	}


	public function scopeDoctors ($query)
	{
		return $query->where('is_doctor', true);
	}


	public function scopeOfLevel ($query, $level)
	{
		return $query->where('level', $level);
	}


	public function scopeWithArticles ($query)
	{
		return $query->with('tags.articles');
	}


	public function scopeOrderByName ($query, $order = 'asc')
	{
		return $query->orderBy('name', $order);
	}


	public function getNbOfUnseenNotifications ()
	{
		return Notification::whereUserId($this->id)
						   ->whereNull('seen_at')
						   ->count();
	}
}
