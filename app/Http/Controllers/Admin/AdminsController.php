<?php
namespace App\Http\Controllers\Admin;


use App\Contact;
use App\Http\Controllers\Controller;
use App\User;
use function array_merge;
use function compact;

class AdminsController extends Controller
{

	public function users ()
	{
		$users = User::with('courses', 'tags')
					 ->orderByName()
					 ->whereLevel(0)
					 ->get();

		$doctors = User::with('supervisedCourses', 'articles', 'news')
					   ->orderByName()
					   ->whereBetween('level', [1, 9])
					   ->get();

		return view('admin.users', compact('users', 'doctors'));
	}


	public function contacts ()
	{
		$doctors = User::orderByName()
					   ->doctors()
					   ->with('contacts')
					   ->get();
		$contacts = Contact::orderBy('type')
						   ->whereNull('user_id')
						   ->get();

		return view('admin.contacts', compact('doctors', 'contacts'));
	}


	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function index ()
	{
		return view('admin.index');
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