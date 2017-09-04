<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
	public function index ()
	{
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
