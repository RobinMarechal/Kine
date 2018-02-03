@extends('layouts.app')

@section('title')
	Cours
@endsection


@section('content')

	<h1>Cours possédant le tag « {{$tagName}} »</h1>
	<hr>

	<div class="row">
		@forelse($courses as $course)
			@include('courses.part', compact('course'))
		@empty
			<p>Aucun cours ne possède ce tag, ou bien vous n'avez pas le droit de consulter les cours possédant ce tag.</p>
		@endforelse
	</div>

	<div class="row">
		<div align="right">{!! $courses->render() !!}</div>

		<hr>
		<div class="section-footer">
			<a href="{{ route('courses.index')}}"><span class="glyphicon glyphicon glyphicon-arrow-right"></span> Voir tous les cours accessibles par vous.</a>
			<a href="{{ url('a-propos#tags') }}"><span class="glyphicon glyphicon glyphicon-arrow-right"></span> En savoir plur sur le système de tags.</a>
		</div>
	</div>

@endsection


@section('js')

@endsection