@extends('layouts.app')

@section('title')
	Articles
@endsection


@section('content')

	<h1>Articles possédant le tag « {{$tagName}} »</h1>
	<hr>

	@forelse($articles as $article)
		@include('articles.parts.article', $article)
	@empty
		<p>Aucun article n'a été publié pour le moment</p>
	@endforelse

	<div align="right">{!! $articles->render() !!}</div>

	<hr>
	<div class="section-footer">
		<a href="{{ url('articles') }}"><span class="fas fa-list-alt"></span> Voir tous les articles disponnibles.</a>
		<a href="{{ url('a-propos#tags') }}"><span class="fas fa-tags"></span> En savoir plur sur le système de tags.</a>
	</div>


@endsection


@section('js')

@endsection