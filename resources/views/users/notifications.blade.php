@extends('layouts.app')

@section('content')

	<h1>Notifications</h1>
	<hr>

	<div class="notifications row">
		@forelse($notifications as $n)
			<div class="row notification-row">
				<a class="notification-block col-lg-8 col-lg-offset-2 {{ isset($n->link) ? 'link' : '' }}" @if(isset($n->link)) href="{{$n->link}}" @endif>
					<p>{{$n->content}}</p>
					<i class="date"> - {{$n->created_at->format('Y/m/d H:i:s')}}</i>
				</a>
			</div>

		@empty
			@if(isset($all) && $all)
				<p>Vous n'avez aucune notification.</p>
			@else
				<p>Vous n'avez aucune nouvelle notification.</p>
			@endif
		@endforelse

		<div align="right">{{$notifications->render()}}</div>

	</div>

	@if(!isset($all) || !$all)
		<hr>
		<a href="{{ url('notifications/tout-voir') }}"><span class="glyphicon glyphicon glyphicon-arrow-right"></span> Voir toutes les notifications </a>
	@endif

@endsection