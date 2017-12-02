<?php

namespace App\Http\Controllers;

use App\About;
use App\Connection;
use App\Content;
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


	public function test ()
	{
		echo $this->request->all();
		dd();
	}


	public function dev ()
	{
		return view('development');
	}


	public function e404 ()
	{
		return view('errors.404');
	}

	public function about()
	{
		$abouts = About::orderBy('title', 'asc')->get();

		return view('others.about', compact('abouts'));
	}

	public function bug()
	{
		return view('others.bugs');
	}

	public function cgu()
	{
		$cgu = Content::getOrCreate('cgu');
		return view('others.cgu', compact('cgu'));
	}
}
