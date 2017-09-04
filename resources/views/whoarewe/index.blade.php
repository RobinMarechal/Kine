@extends('layouts.app')

@section('title')
	Qui Sommes-Nous
@endsection


@section('content')
	<article data-content-id="{{ $content->id }}" class="content-editable editable">
		<h1 id="content-{{$content->id}}-title">
			{{ $content->title }}
		</h1>
		{!! printButtonContent($content->name, ['id' => 'edit-content', 'data-id' => $content->id]) !!}

		<hr>

		<div id="content-{{$content->id}}-content" class="content-box">
			{!! $content->content !!}
		</div>

		<hr>

		<ul class="team-list">
			{{--@forelse($teams as $t)--}}
			{{--<li>--}}
			{{--<a href="{{ url('teams/show/'.$t->slug) }}"> {{ $t->name }} </a>--}}
			{{--@if($t->trashed())--}}
			{{--<span title="Cette team n'est visible que par ses responsables où par ceux du BDA." class="glyphicon glyphicon-exclamation-sign"></span>--}}
			{{--@endif--}}
			{{-- &nbsp; - &nbsp; {!! printUserLink($t->user, 'manager') !!}--}}
			{{--</li>--}}
			{{--@empty--}}
			{{--<p>Aucune team n'a été créée pour le moment.</p>--}}
			{{--@endforelse--}}
		</ul>

	</article>
@endsection