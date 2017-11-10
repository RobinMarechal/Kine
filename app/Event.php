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
	protected $fillable = ['created_at', 'updated_at', 'name', 'description', 'article_id', 'doctor_id', 'views', 'startsAt', 'endsAt'];
	protected $dates = ['deleted_at', 'date'];
	public $temporalField = 'date';


	public function article ()
	{
		return $this->belongsTo('App\Article');
	}


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
		return $query->where('startsAt', '>', getCurrentDatetime());
	}


	public function scopePassed ($query)
	{
		return $query->where('endsAt', '<', getCurrentDatetime());
	}


	public function scopeCurrent ($query)
	{
		$cdt = getCurrentDatetime();

		return $query->where('startsAt', '<=', $cdt)
					 ->where('endsAt', '>=', $cdt);
	}


	public function scopeFromNewerToOlder ($query)
	{
		return $query->orderBy('startsAt', 'DESC')
					 ->orderBy('endsAt', 'DESC');
	}


	public function scopeFromOlderToNewer ($query)
	{
		return $query->orderBy('startsAt', 'ASC')
					 ->orderBy('endsAt', 'ASC');
	}

}