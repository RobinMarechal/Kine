<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{

	protected $table = 'logins';
	public $timestamps = false;
	protected $dates = ['date'];
	protected $fillable = ['id', 'date', 'user_id', 'ip_address'];
	public $temporalField = 'date';


	public function user ()
	{
		return $this->belongsTo('App\User');
	}

}
