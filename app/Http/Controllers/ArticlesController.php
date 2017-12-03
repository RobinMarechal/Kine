<?php

namespace App\Http\Controllers;

use App\Article;
use App\Events\ArticlePublished;
use App\Tag;
use function array_has;
use Carbon\Carbon;
use function explode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use function isAdmin;
use Laracasts\Flash\Flash;
use const null;
use stdClass;

class ArticlesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function index ()
	{
		// Select all the articles that the connected user can access
		if (isAdmin()) {
			$articles = Article::with('tags', 'doctor', 'medias')
							   ->fromNewerToOlder()
							   ->paginate(5);
		}
		else {

			$tags = Auth::check() ? Auth::user()->tags : [];

			$articles = Article::leftJoin('article_tag', 'articles.id', '=', 'article_tag.article_id')
							   ->with('tags', 'doctor', 'medias')
							   ->whereNull('tag_id')
							   ->orWhereIn('tag_id', $tags)
							   ->fromNewerToOlder()
							   ->paginate(5, ['articles.*']);
		}

		return view('articles.index', compact('articles'));
	}


	public function ofTag ($tagName)
	{
		$articles = Article::join('article_tag', 'article_id', '=', 'articles.id')
						   ->join('tags', 'tag_id', '=', 'tags.id')
						   ->with('doctor', 'tags', 'medias')
						   ->where('tags.name', $tagName)
						   ->fromNewerToOlder()
						   ->paginate(10, ['articles.*']);

		return view('articles.ofTag', compact('tagName', 'articles'));
	}


	public function filter ()
	{
	}


	public function search ()
	{
	}


	/**
	 * Show the form for creating a new resource.
	 * @return Response
	 */
	public function create ()
	{
		$tags = Tag::all();

		return view('articles.create', compact('tags'));
	}


	public function preview ()
	{
		$article = new stdClass();
		$article->title = $this->request->title;
		$article->content = $this->request->get('content');
		$article->doctor = Auth::user()->doctor;
		$article->doctor->user = Auth::user();
		$article->views = 0;
		$article->created_at = Carbon::now();
		$article->tags = [];
		$article->id = 0;

		$tagList = explode(';', $this->request->tags);
		foreach ($tagList as $t) {
			$tmp = new Tag();
			$tmp->name = $t;
			$article->tags[] = $tmp;
		}

		return view('articles.show', compact('article'));
	}


	/**
	 * Store a newly created resource in storage.
	 * @return Response
	 */
	public function store ()
	{

		$validation = $this->validator($this->request->all());

		$data = $this->request->only('title', 'content');

		if ($validation->fails()) {
			Flash::error("Le formulaire n'a pas été rempli correctement, l'article n'a pas été publié.");
			return Redirect::back()
						   ->withInput($data)
						   ->withErrors($validation->errors());
		}

		$data['doctor_id'] = Auth::user()->id;

		$article = Article::create($data);

		if ($article == null) {
			Flash::error("Une erreur est survenue, l'article n'as pas été publié.");

			return Redirect::back()
						   ->withInput($data);
		}


		$formTags = $this->request->tags == "" ? [] : explode(";", $this->request->tags);
		$tagNameId = [];
		$tagIds = [];

		if(count($formTags))
		{
			$tagsInDb = Tag::all();

			foreach ($tagsInDb as $tag) {
				$tagNameId[ $tag->name ] = $tag->id;
			}


			foreach ($formTags as $tag) {
				if (array_has($tagNameId, $tag)) {
					$id = $tagNameId[ $tag ];
				}
				else {
					$id = Tag::createFromName($tag)->id;
				}

				$tagIds[] = $id;
			}

			$article->tags()
					->sync($tagIds);
		}

		event(new ArticlePublished($article, $tagIds, $formTags));

		Flash::success("L'article a bien été publié !");

		return redirect('articles/' . $article->id);
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
		$article = Article::with('tags', 'doctor', 'medias')
						  ->findOrFail($id);

		if (!isAdmin()) {
			$article->views++;
			$article->save();
		}

		return view('articles.show', compact('article'));
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
		$article = Article::with('tags')
						  ->find($id);
		$tags = Tag::all();

		return view('articles.create', compact('article', 'tags'));
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
		$validation = $this->validator($this->request->all());

		$data = $this->request->only('title', 'content');

		if ($validation->fails()) {
			Flash::error("Une erreur est survenue, l'article n'as pas été modifié.");
			return Redirect::back()
						   ->withInput($data)
						   ->withErrors($validation->errors());
		}

		$article = Article::findOrFail($id);

		$article->update($data);

		$formTags = $this->request->tags == "" ? [] : explode(";", $this->request->tags);
		$tagNameId = [];
		$tagIds = [];

		if(count($formTags) != 0)
		{
			$tagsInDb = Tag::all();

			foreach ($tagsInDb as $tag) {
				$tagNameId[ $tag->name ] = $tag->id;
			}


			foreach ($formTags as $tag) {
				if (array_has($tagNameId, $tag)) {
					$id = $tagNameId[ $tag ];
				}
				else {
					$id = Tag::createFromName($tag)->id;
				}

				$tagIds[] = $id;
			}

			$article->tags()
					->sync($tagIds);
		}

		event(new ArticlePublished($article, $tagIds, $formTags));

		Flash::success("L'article a bien été modifié !");

		return redirect('articles/' . $article->id);
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


	protected function validator ($data)
	{
		return Validator::make($data, [
			'title' => 'required|min:5|max:255',
		]);
	}


}