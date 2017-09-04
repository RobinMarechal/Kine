<?php

namespace App;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

	protected $table = 'notifications';
	public $timestamps = true;
	protected $fillable = ['created_at', 'updated_at', 'user_id', 'notifiable_id', 'notifiable_type', 'seen_at', 'content', 'link'];
	public $temporalField = 'created_at';


	public function user ()
	{
		return $this->belongsTo('App\User');
	}


	public function scopeOfUser ($query, $user)
	{
		if ($user instanceof User) {
			$user = $user->id;
		}

		return $query->where('user_id', $user);
	}


	public function scopeUnseen ($query, $dont = false)
	{
		if($dont === true)
			return $query;

		return $query->whereNull('seen_at');
	}


	public function scopeFromNewerToOlder ($query)
	{
		return $query->orderBy('created_at', 'DESC');
	}


	// helpers

	public function hasBeenSeen ()
	{
		return !isset($this->seen_at);
	}


	public function getRelatedData ()
	{
		if (!isset($this->notifiable_type)) {
			return null;
		}

		try {
			$class = $this->notifiable_type;
			$data = $class::find($this->notifiable_id);

			return $data;
		} catch (Exception $e) {
			return null;
		}
	}


	public function setSeen ()
	{
		$this->seen_at = Carbon::now()->format('Y-m-d H:i:s');
		$this->save();
	}
}