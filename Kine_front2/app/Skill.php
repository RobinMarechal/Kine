<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
	use SoftDeletes;

	protected $table = 'skills';
	protected $dates = ['deleted_at'];
	public $timestamps = true;
	protected $fillable = ['title', 'content', 'user_id', 'index'];
	public $temporalField = 'created_at';


	public function author ()
	{
		return $this->belongsTo('App\User');
	}


	public function user ()
	{
		return $this->belongsTo('App\User');
	}
}