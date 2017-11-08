<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 13/07/2017
 * Time: 19:49
 */

namespace Helpers;


use App\Contact;
use App\Event;
use App\News;
use App\User;
use Illuminate\Support\Facades\Auth;

Class Template
{
	public static function getDoctors ()
	{
		return User::doctors()
//				   ->with(['contacts'/* => function ($query) {
//					   $query->orderBy('type');
//				   }*/])
				   ->get(['id', 'name']);
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
			$user = new User(Auth::user()->toArray());
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
		return Contact::whereNotNull('user_id')
					  ->orderBy('user_id')
					  ->orderBy('type')
					  ->get();
	}


	public static function getOtherContacts ()
	{
		return Contact::whereNull('user_id')
					  ->orderBy('type')
					  ->get();
	}

}