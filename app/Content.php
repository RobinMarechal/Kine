<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{

	protected $table = 'contents';
	public $timestamps = true;
	protected $fillable = ['name', 'title', 'content', 'updated_at', 'doctor_id'];
	public $temporalField = 'created_at';


	public function author ()
	{
		return $this->belongsTo('App\Doctor');
	}


	public function doctor ()
	{
		return $this->belongsTo('App\Doctor');
	}


	public function scopeOfName ($query, $name)
	{
		return $query->where('name', $name);
	}


	public static function createDefault ($name)
	{
		return self::create(['name' => $name, 'title' => 'Title', 'content' => 'Content']);
	}

	public static function getOrCreate($name)
	{
		$content = Content::ofName($name)->first();
		if(!isset($content))
			$content = Content::createDefault($name);

		return $content;
	}
}