<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{

	protected $table = 'articles';
	public $timestamps = true;
	public $urlNamespace = 'articles';

	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = ['user_id', 'title', 'content', 'picture', 'views', 'created_at', 'updated_at', 'views'];
	public $temporalField = 'created_at';


	public function tags ()
	{
		return $this->belongsToMany('App\Tag');
	}


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
		return $this->morphMany('App\Media', 'mediaable');
	}




	public function scopeFromNewerToOlder ($query)
	{
		return $query->orderBy('created_at', 'DESC');
	}


	public function scopeFromOlderToNewer ($query)
	{
		return $query->orderBy('created_at', 'ASC');
	}
}