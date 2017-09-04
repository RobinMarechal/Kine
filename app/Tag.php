<?php

namespace App;

use function explode;
use Illuminate\Database\Eloquent\Model;
use function strlen;
use function strtolower;
use function strtoupper;
use function substr;

class Tag extends Model
{

	protected $table = 'tags';
	public $timestamps = false;
	protected $fillable = ['name'];


	public static function createFromName ($name)
	{
		$name = self::formatName($name);
		return Tag::create(['name' => $name]);
	}


	public static function formatName ($name)
	{
		$parts = explode(' ', $name);
		$res = "";
		if ($name != "") {
			foreach ($parts as $p) {
				$res .= strtoupper(substr($p, 0, 1)) . strtolower(substr($p, 1)) . ' ';
			}

			$res = substr($res, 0, -1);
		}

		return $res;
	}


	public function users ()
	{
		return $this->belongsToMany('App\User');
	}


	public function articles ()
	{
		return $this->belongsToMany('App\Article');
	}


	public function courses ()
	{
		return $this->belongsToMany('App\Course');
	}


	public static function findOrCreate ($name)
	{
	}

}