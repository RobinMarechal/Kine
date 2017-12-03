<?php

namespace App;

use Carbon\Carbon;
use function getCurrentDatetime;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

	protected $table = 'events';
	public $urlNamespace = 'evenements';
	public $timestamps = true;
	protected $fillable = ['name', 'description', 'article', 'doctor_id', 'views', 'starts_at', 'ends_at'];
	protected $dates = ['deleted_at', 'starts_at', 'ends_at'];
	public $temporalField = 'starts_at';


	public function creator ()
	{
		return $this->belongsTo('App\Doctor');
	}


	public function doctor ()
	{
		return $this->belongsTo('App\Doctor');
	}


	public function medias ()
	{
		return $this->morphMany('App\Media');
	}


	public function scopeFuture ($query)
	{
		return $query->where('starts_at', '>', getCurrentDatetime());
	}


	public function scopePassed ($query)
	{
		return $query->where('ends_at', '<', getCurrentDatetime());
	}


	public function scopeCurrent ($query)
	{
		$cdt = getCurrentDatetime();

		return $query->where('starts_at', '<=', $cdt)
					 ->where('ends_at', '>=', $cdt);
	}


	public function scopeFromNewerToOlder ($query)
	{
		return $query->orderBy('starts_at', 'DESC')
					 ->orderBy('ends_at', 'DESC');
	}


	public function scopeFromOlderToNewer ($query)
	{
		return $query->orderBy('starts_at', 'ASC')
					 ->orderBy('ends_at', 'ASC');
	}

}