@extends('layouts.app')

@section('title')
	News
@endsection


@section('content')
	<h1>Dernières actualités
		@if(isAdmin())
			{!! addButton(\App\News::class, ['title' => 'Créer une news', 'data-placement' => 'left']) !!}
		@endif
	</h1>
	<hr>

	@forelse($news as $n)
		<div class="news-block">
			<h3 class="news-title"><a href="{{ url('news/'.$n->id) }}">{{ $n->title }}</a></h3>

			<p class="news-content">{!! cut($n->content, 400) !!}</p>

			<p class="news-published_at written-by">Publiée par {{ $n->doctor->name }}, le {{ $n->published_at->format('d/m/Y') }}</p>
			<p class="written-by">Vue {{number_format($n->views, 0, '.', ' ')}} fois</p>

		</div>
	@empty
		@if(isset($incoming) && $incoming === true)
			<p>Pas de news planifiée.</p>
		@else
			<p>Aucune news n'a été publiée pour le moment.</p>
		@endif
	@endforelse

	<div align="right">{!! $news->render() !!}</div>

	@if(isAdmin())
		<hr>
		@if(isset($incoming) && $incoming === true)
			<a href="/news"> <i class="far fa-newspaper"></i> Voir les news récemment publiées</a>
		@else
			<a href="/news/a-venir"> <i class="far fa-calendar-alt"></i> Voir les news planifiées</a>
		@endif
	@endif

@endsection


@section('js')

@endsection