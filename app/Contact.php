<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function str_replace;
use function strlen;
use function substr;

class Contact extends Model
{

	public $urlNamespace = 'contacts';
	protected $table = 'contacts';
	public $timestamps = true;

//	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = ['created_at', 'updated_at', 'type', 'value', 'display', 'doctor_id', 'name'];
	public $temporalField = 'created_at';


	public function doctor ()
	{
		return $this->belongsTo('App\Doctor');
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
		$value = $this->display ?: $this->value;

		if ($type == "PHONE") {
			$value = str_replace(" ", "", $value);
			$value = str_replace("+33", "0", $value);

			$res = "";

			if(!isset($this->display)) {
				if (isset($value[9])) {
					for ($i = 0; $i < 10; $i += 2) {
						$res .= ' ' . $value[ $i ] . $value[ $i + 1 ];
					}
					$res = substr($res, 1);
				}
				else {
					return "ERROR";
				}
			}
			else{
				$res = $this->display;
			}


			$tag = "<a href='tel:$this->value' data-toggle='tooltip' data-placement='top' title='$this->name'>$res</a>";
			return $tag;
		}
		else if ($type == "EMAIL") {
			$display = $this->display ?: $this->value;

			$tag = "<a href='mailto:$this->value' data-toggle='tooltip' data-placement='top' title='$this->name'> $display </a>";
			return $tag;
		}
		else if ($type == "ADDRESS") {
			$link = "https://www.google.fr/maps?q=" . $this->value;
			$display = $this->display ?: $this->value;

			$tag = "<a target='_blank' href='$link' data-toggle='tooltip' data-placement='top' title='$this->name'> $display </a>";
			return $tag;
		}
		else if ($type == "LINK") {
			$name = $this->name;
			if(!isset($this->display)) {
				if ($name == null) {
					$name = $this->value;
					$name = str_replace("http://", "", $name);
					$name = str_replace("https://", "", $name);
					$display = $name;
				}
			}
			else{
				$display = $this->display;
			}

			$tag = "<a target='_blank' href='$this->value' data-toggle='tooltip' data-placement='top' title='$this->name'> $display </a>";

			return $tag;
		}
	}
}