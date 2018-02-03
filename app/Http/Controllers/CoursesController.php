<?php

namespace App\Http\Controllers;

use App\Course;

class CoursesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function index ()
	{

		// Select all the courses that the connected user can access
		if (isAdmin()) {
			$courses = Course::with('tags', 'doctors', 'clients', 'medias', 'creator')
							 ->fromNewerToOlder()
							 ->paginate(5);
		}
		else {

			$tags = Auth::check() ? Auth::user()->tags : [];

			$courses = Course::leftJoin('course_tag', 'courses.id', '=', 'course_tag.course_id')
							 ->with('tags', 'doctors', 'clients', 'medias', 'creator')
							 ->whereNull('tag_id')
							 ->orWhereIn('tag_id', $tags)
							 ->fromNewerToOlder()
							 ->paginate(5, ['courses.*']);
		}

		return view('courses.index', compact('courses'));
	}


	public function ofTag ($tagName)
	{
		$courses = Course::join('course_tag', 'course_id', '=', 'courses.id')
						 ->join('tags', 'tag_id', '=', 'tags.id')
						 ->with('doctors', 'tags', 'medias', 'clients', 'creator')
						 ->where('tags.name', $tagName)
						 ->fromNewerToOlder()
						 ->paginate(10, ['courses.*']);

		return view('courses.ofTag', compact('tagName', 'courses'));
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