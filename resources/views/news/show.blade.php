@extends('layouts.app')

@section('title')
	{{ $news->title }}
@endsection

@section('content-header')
@endsection


@section('content')

	<div class="editable content-editable">
		@if(isAdmin())
			<div id="news-visibility-info" class="top-left-info" @if(!$news->published_at->gt(new Carbon\Carbon())) hidden @endif >
					<i data-toggle="tooltip"
					   data-placement="top"
					   title="Cette news sera publiée le {{ $news->published_at->format('d/m/Y') }}."
					   data-title-template="Cette news sera publiée le {date}."
					   data-title-template-variable="date"
					   class="fa fa-clock-o top-left-symbol">
					</i>
				</span>
			</div>
		@endif

		{!! printButtonContent("", ['id' => 'edit-news', 'data-id' => $news->id, 'title' => 'Modifier la news']) !!}
		@if(isAdmin())
			<button id="btn-remove-news"
					data-toggle="tooltip"
					data-placement="left"
					title="Supprimer la news"
					data-id="{{ $news->id }}"
					class="btn-remove btn btn-primary btn-edit trash create-new glyphicon glyphicon-trash">
			</button>
		@endif

		<h1 id="news-title"> {{ $news->title }} </h1>
		<hr>
		<div id="news-content" class="news-content">
			{!! $news->content !!}
		</div>


		<p class="written-by" align="right">Publiée par {{$news->doctor->name}}, le <span id="news-published_at" class="news-published_at">{{$news->published_at->format('d/m/Y')
	}}</span></p>
			<p class="written-by nb-of-views" align="right">Vue {{number_format($news->views, 0, '.', ' ')}} fois</p>

	</div>
@endsection


@section('js')

@endsection