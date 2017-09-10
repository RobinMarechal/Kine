<?php

namespace App\Http\Controllers;

use Helpers\JsVar;

class MainController extends Controller
{
	public function index ()
	{
		JsVar::create('test', ['abc' => 1, 'def' => 'ghi']);

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
