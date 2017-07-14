<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function str_replace;
use function strlen;
use function substr;

class Contact extends Model
{

	protected $table = 'contacts';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = ['created_at', 'updated_at', 'type', 'value', 'description', 'user_id'];


	public function doctor ()
	{
		return $this->belongsTo('App\User');
	}


	// Helpers

	public function getFontAwesomeIconClass ()
	{
		$type = $this->type;
		$class = null;

		switch ($type) {
			case "PHONE" :
				$class = "phone";
				break;
			case "EMAIL":
				$class = "envelope";
				break;
			case "ADDRESS" :
				$class = "map-marker";
				break;
			case "LINK" :
				$class = "link";
				break;
		}

		if (isset($class)) {
			$class = 'fa-' . $class;
		}

		return $class;
	}


	public function getFormattedValue ()
	{
		$type = $this->type;
		$value = $this->value;

		if ($type == "PHONE") {
			$value = str_replace(" ", "", $value);
			$value = str_replace("+33", "0", $value);

			$res = "";

			for ($i = 0; $i < 10; $i += 2) {
				$res .= ' ' . $value[ $i ] . $value[ $i + 1 ];
			}

			$res = substr($res, 1);

			$tag = "<p data-toggle='tooltip' data-placement='top' title='$this->description'>$res</p>";
			return $tag;
		}
		else if ($type == "EMAIL") {
			$name = $this->value == null ? $this->name : $this->value;

			$tag = "<a href='mailto:$this->value' data-toggle='tooltip' data-placement='top' title='$this->description'> $name </a>";
			return $tag;
		}
		else if ($type == "ADDRESS") {
			$link = "https://www.google.fr/maps?q=" . $this->value;
			$name = $this->name == null ? $this->value : $this->name;

			$tag = "<a href='$link' data-toggle='tooltip' data-placement='top' title='$this->description'> $name </a>";
			return $tag;
		}
		else if ($type == "LINK") {
			$name = $this->name;
			if ($name == null) {
				$name = $this->value;
				$name = str_replace("http://", "", $name);
				$name = str_replace("https://", "", $name);
			}
			$tag = "<a href='$this->value' data-toggle='tooltip' data-placement='top' title='$this->description'> $name </a>";

			return $tag;
		}
	}
}