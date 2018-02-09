<?php

namespace App;

use function array_column;
use function array_filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function in_array;

class Course extends Model
{

	protected $table = 'courses';
	public $timestamps = true;
	public $urlNamespace = 'cours';

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


	public function creator ()
	{
		return $this->belongsTo('App\Doctor')->withTrashed();
	}


	public function doctors ()
	{
		return $this->belongsToMany('App\Doctor');
	}


	public function courses ()
	{
		return $this->belongsToMany('App\Tag');
	}


	public function medias ()
	{
		return $this->morphMany('App\Media', 'mediaable');
	}


	public function tags ()
	{
		return $this->belongsToMany('App\Tag');
	}


	public function scopeFromNewerToOlder ($query)
	{
		return $query->orderBy('created_at', 'DESC');
	}


	public function scopeFromOlderToNewer ($query)
	{
		return $query->orderBy('created_at', 'ASC');
	}


	// ---

	public function hasClient ($user)
	{
		if (!isset($user)) {
			return false;
		}

		$ids = array_column($this->clients->toArray(), 'id');

		return in_array($user->id, $ids);
	}

}