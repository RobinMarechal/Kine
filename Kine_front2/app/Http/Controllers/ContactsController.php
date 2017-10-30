<?php

namespace App\Http\Controllers;

use App\Content;
use App\User;
use function compact;

class ContactsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function index ()
	{
	}


	public function whoAreWe ()
	{
		$content = Content::getOrCreate('whoarewe');

		return view('whoarewe.index', compact('content'));
	}


	/**
	 * Show the form for creating a new resource.
	 * @return Response
	 */
	public function create ()
	{
	}


	/**
	 * Store a newly created resource in storage.
	 * @return Response
	 */
	public function store ()
	{
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show ($id)
	{
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit ($id)
	{
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update ($id)
	{
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy ($id)
	{
	}

}