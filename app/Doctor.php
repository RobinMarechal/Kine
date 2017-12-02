<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use function json_encode;
use function property_exists;

class Doctor extends Model
{

	use Notifiable;
	protected $table = 'doctors';
	public $urlNamespace = 'kines';
	public $timestamps = true;
	public $incrementing = false;

	protected $dates = ['deleted_at'];
	protected $fillable = ['id', 'resume', 'description', 'phone', 'starts_at', 'ends_at', 'name'];
	public $temporalField = 'created_at';


	public function articles()
	{
		return $this->hasMany('App\Article');
	}

	public function news()
	{
		return $this->hasMany('App\News');
	}

	public function medias()
	{
		return $this->hasMany('App\Media');
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'id');
	}

	public function contacts()
	{
		return $this->hasMany('App\Contact');
	}


	public function contents ()
	{
		return $this->belongsTo('App\Content');
	}


	public function removedContents ()
	{
		return $this->belongsTo('App\RemovedContent');
	}


	public function courses ()
	{
		return $this->belongsToMany('App\Course');
	}

	public function events ()
	{
		return $this->belongsTo('App\Event');
	}


	public function skills ()
	{
		return $this->belongsTo('App\Skill');
	}


	public function scopeOrderByName ($query, $order = 'asc')
	{
		return $query->orderBy('name', $order);
	}


	public function getName ()
	{
		return $this->user->name;
	}

	public function scopeWithoutMe($query)
	{
		return $query->whereNotIn('email', ['robin-marechal@hotmail.fr', 'lsem@dmin']);
	}

	public function toJson ($options = 0)
	{
		$doc = $this->toArray();
		if(isset($doc['user'])){
			$doc['user'] = $doc['user']->toArray();
			unset($doc['user']['doctor']);
		}

		return json_encode($doc, $options);
	}
}
