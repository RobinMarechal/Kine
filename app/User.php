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
	protected $fillable = ['email', 'name', 'facebook_id', 'password', 'is_doctor', 'connections'];
	protected $hidden = ['facebook_id', 'password'];
	public $temporalField = 'created_at';


	public function tags ()
	{
		return $this->belongsToMany('App\Tag');
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


	public function doctor ()
	{
		return $this->hasOne('App\Doctor', 'id');
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


//	public function toJson ($options = 0)
//	{
//		$tmp = $this->getRelation('user');
//		$this->setRelation('user', null);
//		$json = parent::__toString();
//		$this->setRelation('user', $tmp);
//
//		return $json;
//	}
}
