<?php

namespace App;

class RemovedContent extends Content
{

	protected $table = 'removed_contents';
	public $timestamps = false;
	protected $fillable = ['name', 'content', 'created_at', 'updated_at', 'doctor_id', 'removed_at', 'slug'];
	protected $dates = ['removed_at'];
	public $temporalField = 'created_at';
}