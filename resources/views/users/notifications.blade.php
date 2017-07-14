@extends('layouts.app')

@section('content')

	<h1>Notifications</h1>
	<hr>

	<div class="notifications">
		@forelse($notifications as $n)

			<a class="notification" href="{{$n->link}}">
				{{$n->content}}
			</a>

		@empty
			@if(isset($all) && $all)
				<p>Vous n'avez aucune notification.</p>
			@else
				<p>Vous n'avez aucune nouvelle notification.</p>
			@endif
		@endforelse

	</div>

	<hr>
	@if(!isset($all) || !$all)
		<a href="{{ url('users/notifications/all') }}"><span class="glyphicon glyphicon glyphicon-arrow-right"></span> Voir toutes les notifications </a>
	@endif

@endsection