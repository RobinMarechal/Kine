@extends('layouts.app')

@section('title')
	{{ $article->title }}
@endsection


@section('content')
	<div class="editable content-editable">

		{{--		{!! printButtonContent("", ['href' => url('articles/'.$article->id.'/modifier'), 'id' => 'edit-article', 'data-id' => $article->id, 'title' => "Modifier l'article"]) !!}--}}
		@if($article->id > 0)

			<a href="{{ url('articles/'.$article->id.'/modifier') }}"
			   data-toggle="tooltip"
			   data-placement="top"
			   title="Modifier l'article"
			   class="btn btn-edit btn-primary ">
				<span class="glyphicon glyphicon-pencil"></span>
			</a>
			@if(isAdmin())
				<button id="btn-remove-article"
						data-toggle="tooltip"
						data-placement="left"
						title="Supprimer l'article"
						data-id="{{ $article->id }}"
						class="btn-remove btn btn-primary btn-edit trash create-new glyphicon glyphicon-trash">
				</button>
			@endif

		@endif

		<h1 id="article-title"> {{ $article->title }} </h1>
		<hr>
		<div id="article-content"
			 class="article-content">
			{!! $article->content !!}
		</div>

		<br>

		<div class="tags-block">
			@forelse($article->tags as $tag)
				<a href="{{url('articles/tag/'.$tag->name)}}"
				   class="tag"
				   title="Cliquez pour voir tous les articles possédant ce tag">{{$tag->name}}</a>
			@empty
			@endforelse
		</div>

		<p class="written-by"
		   align="right">Publiée par {{$article->doctor->getName()}}, le <span id="article-created_at"
																		  class="article-created_at">{{$article->created_at->format
		('d/m/Y')
	}}</span></p>
		<p class="written-by nb-of-views"
		   align="right">Vue {{number_format($article->views, 0, '.', ' ')}} fois</p>

	</div>
@endsection


@section('js')

@endsection