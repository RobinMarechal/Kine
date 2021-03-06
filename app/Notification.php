<?php

namespace App;

use Carbon\Carbon;
use Exception;
use function get_call_stack;
use function get_class;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

	protected $table = 'notifications';
	public $urlNamespace = 'notifications';
	public $timestamps = true;
	protected $fillable = ['created_at', 'updated_at', 'user_id', 'notifiable_id', 'notifiable_type', 'seen_at', 'content', 'link'];
	public $temporalField = 'created_at';


	public static function sendToUser ($user, $message, $notifiable = null)
	{
		$userId = $user instanceof User ? $user->id : $user;

		$data = [
			'user_id' => $userId,
			'content' => $message,
		];

		if (isset($notifiable)) {
			$data['notifiable_id'] = $notifiable->id;
			$data['notifiable_type'] = get_class($notifiable);
			$data['link'] = str_replace("App\\", "", $notifiable->urlNamespace) . '/' . $notifiable->id;
		}
		
		return self::create($data);
	}


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
		if ($dont === true) {
			return $query;
		}

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
		$this->seen_at = Carbon::now()
							   ->format('Y-m-d H:i:s');
		$this->save();
	}
}