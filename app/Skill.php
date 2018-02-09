<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
	use SoftDeletes;

	protected $table = 'skills';
	public $urlNamespace = 'nos-compétences';
	protected $dates = ['deleted_at'];
	public $timestamps = true;
	protected $fillable = ['title', 'content', 'doctor_id', 'index'];
	public $temporalField = 'created_at';


	public function author ()
	{
		return $this->doctor();
	}


	public function doctor ()
	{
		return $this->belongsTo('App\Doctor')->withTrashed();
	}
}
