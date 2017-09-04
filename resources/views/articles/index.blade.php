@extends('layouts.app')

@section('title')
	Articles
@endsection


@section('content')

	<h1>Articles publiés
		@if(isAdmin())
			<a data-toggle="tooltip" data-placement="left" title="Rédiger un article" href="{{ url('articles/rediger') }}" class="create-new glyphicon glyphicon-plus
			title-btn-hover"></a>
		@endif
	</h1>
	<hr>

	@forelse($articles as $article)
		@include('articles.parts.article', $article)
	@empty
		<p>Aucun article n'a été publié pour le moment</p>
	@endforelse

	<div align="right">{!! $articles->render() !!}</div>

	<hr>
	<div class="section-footer">
		<a href="{{ url('a-propos#tags') }}"><span class="glyphicon glyphicon glyphicon-arrow-right"></span> En savoir plur sur le système de tags.</a>
	</div>


@endsection


@section('js')

@endsection