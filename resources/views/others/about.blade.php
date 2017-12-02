@extends('layouts.app')

@section('title')
	{{--À--}} A Propos
@endsection


@section('content')
	<h1>
		A Propos
		@if(isAdmin())
			<a data-toggle="tooltip" data-namespace="abouts" data-placement="left" title="Ajouter une rubrique" href="#" class="create-data create-new create-about glyphicon
			glyphicon-plus
			title-btn-hover"></a>
		@endif
	</h1>
	<hr>

	<div id="abouts">

		{{--@include('others.about_part', compact('about'))--}}
		{{--@include('others.about_part', compact('about'))--}}
		{{--@include('others.about_part', compact('about'))--}}
		{{--@include('others.about_part', compact('about'))--}}

		@forelse($abouts as $about)
			@include('others.about_part', compact('about'))
		@empty

		@endforelse

	</div>

@endsection


@section('js')

@endsection