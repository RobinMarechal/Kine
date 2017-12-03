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
		@forelse($courses as $course)
			@include('courses.part', compact('course'))
		@empty
			<p>Vous n'avez accès à aucun cours pour le moment.</p>
		@endforelse
		@forelse($courses as $course)
			@include('courses.part', compact('course'))
		@empty
			<p>Vous n'avez accès à aucun cours pour le moment.</p>
		@endforelse
		@forelse($courses as $course)
			@include('courses.part', compact('course'))
		@empty
			<p>Vous n'avez accès à aucun cours pour le moment.</p>
		@endforelse
	</div>

@endsection


@section('js')

@endsection