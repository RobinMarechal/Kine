<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 18/09/2017
 * Time: 18:27
 */

namespace Helpers;


use Facebook\Facebook;

class FacebookHelper
{
	public static function getFacebookInstance ()
	{
		return new Facebook([
			'app_id' => env('FACEBOOK_CLIENT_ID'),
			'app_secret' => env('FACEBOOK_CLIENT_SECRET'),
			'default_graph_version' => 'v2.10'
		]);
	}
}