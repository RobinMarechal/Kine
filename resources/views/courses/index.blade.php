@extends('layouts.app')

@section('title')
	Cours
@endsection


@section('content')
	<h1>Cours</h1>
	<hr>

	<div class="row">
		@forelse($courses as $course)
			@include('courses.part', compact('course'))
		@empty
			<p>Vous n'avez accès à aucun cours pour le moment.</p>
		@endforelse
	</div>

	<div class="row">

		<div align="right">{!! $courses->render() !!}</div>

		<hr>
		<div class="section-footer">
			<a href="{{ url('a-propos#tags') }}"><span class="glyphicon glyphicon glyphicon-arrow-right"></span> En savoir plur sur le système de tags.</a>
		</div>
	</div>

@endsection


@section('js')

@endsection