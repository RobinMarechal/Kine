<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{

	protected $table = 'news';
	public $timestamps = true;
	public $urlNamespace = 'news';

	use SoftDeletes;

	protected $dates = ['deleted_at', 'published_at'];
	protected $fillable = ['created_at', 'updated_at', 'doctor_id', 'title', 'content', 'published_at', 'views'];
	public $temporalField = 'published_at';


	public function author ()
	{
		return $this->belongsTo('App\Doctor');
	}


	public function doctor ()
	{
		return $this->belongsTo('App\Doctor');
	}


	public function medias ()
	{
		return $this->morphMany('App\Media', 'mediaable');
	}


	public function scopePublished ($query)
	{
		return $query->where('published_at', '<=', Carbon::now()
														 ->format("Y-m-d H:i:s"));
	}


	public function scopeNotPublished ($query)
	{
		return $query->where('published_at', '>', Carbon::now()
														 ->format("Y-m-d H:i:s"));
	}


	public function scopeFromNewerToOlder ($query)
	{
		return $query->orderBy('published_at', 'DESC');
	}


	public function scopeFromOlderToNewer ($query)
	{
		return $query->orderBy('published_at', 'ASC');
	}
}