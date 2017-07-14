<?php

use Carbon\Carbon;

function getGoogleConfigs ()
{
	return Config::get('services.google');
}

function getGoogleApiKey ()
{
	return getGoogleConfigs()['api_key'];
}

function getTimeString($time, $withSeconds = false)
{
	$time = Carbon::parse($time);

	$format = 'H:i';
	if($withSeconds)
		$format .= ':s';

	return $time->format($format);
}

function printButtonContent ($name, array $attrs = [], $addClasses = '')
{
	if (Auth::check() && Auth::user()->level > 1) {
		$attrStr = '';
		if (!empty($attrs)) {
			foreach ($attrs as $a => $v) {
				if ($a != 'class') {
					$attrStr .= ' ' . $a . '="' . $v . '"';
				}
			}
		}
		$str = '<button' . $attrStr . ' data-name="' . $name . '" class="btn btn-edit btn-primary ' . $addClasses . '"><span class="glyphicon glyphicon-pencil"></span></button>';

		return $str;
	}
}

function printButton ($name, $glyphicon = 'pencil', array $attrs = [], $addClasses = '')
{
	if (Auth::check() && Auth::user()->level > 1) {
		$attrStr = '';
		if (!empty($attrs)) {
			foreach ($attrs as $a => $v) {
				if ($a != 'class') {
					$attrStr .= ' ' . $a . '="' . $v . '"';
				}
			}
		}
		$str = '<button' . $attrStr . ' data-name="' . $name . '" class="btn btn-edit btn-primary ' . $addClasses . '"><span class="glyphicon glyphicon-' . $glyphicon . '"></span></button>';

		return $str;
	}
}

function printButtonTrashRestore ($id, array $attrs = [], $addClasses = '')
{
	$attrStr = '';
	if (!empty($attrs)) {
		foreach ($attrs as $a => $v) {
			if ($a != 'class') {
				$attrStr .= ' ' . $a . '="' . $v . '"';
			}
		}
	}
	$str = '<button' . $attrStr . ' data-id="' . $id . '" class="btn btn-edit btn-primary ' . $addClasses . '"><span class="glyphicon glyphicon-pencil"></span></button>';

	return $str;
}

function cut ($str, $n, $link = false)
{
	$string = $str;
	if (strlen($str) > $n) {
		$substr = substr($str, 0, $n);
		$left = '<i><b>.....</b></i>';
		if ($link != false) {
			$left = '<a title="Cliquez pour voir la suite" href="' . url($link) . '">' . $left . '</a>';
		}
		$string = $substr . $left . '</p>';
	}

	return $string;
}

function glyph ($str)
{
	return 'glyphicon glyphicon-' . $str;
}

function getWeekDay ($date = "")
{
	if ($date == "") {
		$date = strtotime(date("Y-m-d"));
	}
	$day = date('N', $date) - 1;

	return day($day);
}

function printDay ($id, $three = false)
{
	return day($id, $three);
}

/**
 * print a link which leads to $user's profile
 *
 * @param \App\User $user    : user's instance
 * @param string    $classes : tag classes
 *
 * @return string $link : HTML tag <a>
 */
function printUserLink (App\User $user, $classes = '')
{
	$name = $user->first_name . ' ' . $user->last_name;

	$link = '<a class="' . $classes . '" href="' . url('users/show/' . $user->id) . '">' . $name . '</a>';

	return $link;
}

/**
 * print a link which leads to $team's page
 *
 * @param \App\Team $team    : team's instance
 * @param string    $classes : tag classes
 *
 * @return string $link : HTML tag <a>
 */
function printTeamLink (App\Team $team, $classes = '')
{
	$link = '<a class="' . $classes . '" href="' . url('teams/show/' . $team->slug) . '">' . $team->name . '</a>';

	return $link;
}

/**
 * Get the current datetime with format 'Y-m-d H:i:s'
 * Example : '2017-05-23 16:15:30'
 * @return string the current datetime of format 'Y-m-d H:i:s'
 */
function getCurrentDatetime ()
{
	return Carbon::now()
				 ->format('Y-m-d H:i:s');
}