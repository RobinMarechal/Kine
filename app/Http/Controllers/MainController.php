<?php

namespace App\Http\Controllers;

use App\Connection;
use Exception;

class MainController extends Controller
{
	public function index ()
	{
		$userIp = $this->request->server("REMOTE_ADDR");

		$test = Connection::whereIpAddress($userIp)->first();
		if(!isset($test)) {
			Connection::create(['ip_address' => $userIp]);
		}

		return view('home');
	}


	public function dev ()
	{
		return view('development');
	}


	public function e404 ()
	{
		return view('errors.404');
	}
}
