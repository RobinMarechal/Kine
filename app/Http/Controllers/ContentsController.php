<?php

namespace App\Http\Controllers;

use App\Content;
use Illuminate\Support\Facades\Response;
use function random_int;
use function str_slug;

class ContentsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function index ()
	{
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


	// API

	public function find ($id)
	{
		$content = Content::find($id);

		return response()->json($content);
	}


//	public function post ()
//	{
//		$data = $this->request->all();
//
//		$data['name'] = 'skills__' . str_slug($data['title']);
//
//		while (Content::where('name', $data['name'])
//					  ->first() != null) {
//			$data['name'] .= random_int(0, 99999);
//		}
//
//		$content = Content::create($data);
//
//		return $content;
//	}
}