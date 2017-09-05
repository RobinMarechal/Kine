@extends('layouts.app')

@section('title')
	Page Introuvable
@endsection


@section('content')
	<h1>Erreur 404 !</h1>
	<hr>
	<p>La page demandée est introuvable...</p>

	<hr>
	<div class="section-footer">
		<a href="{{ url('a-propos#erreurs-404') }}"><span class="glyphicon glyphicon glyphicon-arrow-right"></span> Qu'est-ce que cela signifie ?</a>
	</div>

@endsection


@section('js')

@endsection