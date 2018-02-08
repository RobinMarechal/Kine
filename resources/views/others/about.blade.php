@extends('layouts.app')

@section('title')
	{{--À--}} A Propos
@endsection


@section('content')
	<h1>
		A Propos
		@if(isAdmin())
			{!! addButton(\App\About::class, ['title' => 'Ajouter une rubrique', 'data-placement' => 'left']) !!}

		@endif
	</h1>
	<hr>

	<div id="abouts">

		@forelse($abouts as $about)
			@include('others.about_part', compact('about'))
		@empty

		@endforelse

	</div>

@endsection


@section('js')

@endsection