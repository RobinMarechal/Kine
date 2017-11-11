<?php
namespace App\Http\Controllers\Admin;


use App\Contact;
use App\Doctor;
use App\Http\Controllers\Controller;
use App\User;
use function array_merge;
use function compact;
use PhpParser\Comment\Doc;

class AdminsController extends Controller
{

	public function users ()
	{
		$users = User::with('courses', 'tags')
					 ->orderByName()
					 ->whereIsDoctor(0)
					 ->get();

		$doctors = Doctor::with('courses', 'articles', 'news', 'user')
						 ->where('id', '>', 1)
						 ->orderByName()
						 ->get();

		return view('admin.users', compact('users', 'doctors'));
	}


	public function contacts ()
	{
		$doctors = Doctor::orderByName()
						 ->where('id', '>', 1)
						 ->with('contacts')
						 ->get();
		$contacts = Contact::orderBy('type')
						   ->whereNull('doctor_id')
						   ->get();

		return view('admin.contacts', compact('doctors', 'contacts'));
	}


	public function showUser ($id)
	{
		$doctor = Doctor::with('contacts',
			'courses.tags',
			'courses.users',
			'articles.tags',
			'news')
						->findOrFail($id);

		return view('admin.user', compact('doctor'));
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