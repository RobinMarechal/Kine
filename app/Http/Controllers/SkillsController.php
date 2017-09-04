<?php

namespace App\Http\Controllers;

use App\Content;
use App\Skill;
use function compact;
use Illuminate\Http\Request;

class SkillsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$skills = Skill::orderBy('index')->orderBy('title')->get();

		return view('skills.index', compact('skills'));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param $id
	 *
	 * @return Response
	 * @internal param string $slug
	 */
	public function show($id)
	{
		$skill = Skill::find($id);
		$skills = Skill::orderBy('title')->get(['id', 'title']);

		return view('skills.index', compact('skills', 'skill'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

	}
}
