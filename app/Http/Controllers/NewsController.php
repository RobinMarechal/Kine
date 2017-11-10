<?php

namespace App\Http\Controllers;

use App\News;
use function isAdmin;

class NewsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @param bool $incoming
	 *
	 * @return Response
	 */
	public function index ($incoming = false)
	{
		if (!$incoming) {
			$news = News::with('doctor')
						->published()
						->fromNewerToOlder()
						->paginate(5);
		}
		else {
			$news = News::with('doctor')
						->notPublished()
						->fromOlderToNewer()
						->paginate(5);
		}

		return view('news.index', compact('news', 'incoming'));
	}


	public function future ()
	{
		return $this->index(true);
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
		$news = News::with('doctor', 'medias')
					->findOrFail($id);

		if (!isAdmin()) {
			$news->views++;
			$news->save();
		}

		return view('news.show', compact('news'));
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