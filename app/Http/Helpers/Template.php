<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 13/07/2017
 * Time: 19:49
 */

namespace Helpers;


use App\Contact;
use App\Doctor;
use App\Event;
use App\News;
use App\User;
use Illuminate\Support\Facades\Auth;
use PhpParser\Comment\Doc;

Class Template
{
	public static function getDoctors ()
	{
		$d = Doctor::where('id', '>', 1)
				   ->get(['id', 'name']);

		return $d;
	}


	public static function getNews ()
	{
		return News::published()
				   ->fromNewerToOlder()
				   ->limit(5)
				   ->get();
	}


	public static function getEvents ()
	{
		return Event::future()
					->fromOlderToNewer()
					->limit(5)
					->get();
	}


	public static function getNbOfNotifications ()
	{
		$nbOfNotifications = null;
		if (Auth::check()) {
			$user = new User(Auth::user()
								 ->toArray());
			$user->id = Auth::user()->id;
			$nbOfNotifications = $user->getNbOfUnseenNotifications();
			if ($nbOfNotifications == 0) {
				$nbOfNotifications = null;
			}
		}

		return $nbOfNotifications;
	}


	public static function getContacts ()
	{
		return Contact::whereNotNull('doctor_id')
					  ->orderBy('doctor_id')
					  ->orderBy('type')
					  ->get();
	}


	public static function getOtherContacts ()
	{
		return Contact::whereNull('doctor_id')
					  ->orderBy('type')
					  ->get();
	}

}