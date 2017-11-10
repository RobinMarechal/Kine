<?php

use Helpers\JsVar;
use Helpers\Template;
use Illuminate\Database\Eloquent\Collection;

$nbOfNotifications = Template::getNbOfNotifications();

$isCurrentPageHomePage = false;
if (Route::currentRouteName() === "home" || Route::currentRouteName() === "home") {
	$isCurrentPageHomePage = true;
}
$contentBootstrapClassCol = "col-md-9";
//$contentBootstrapClassCol = $isCurrentPageHomePage ? "col-md-12" : "col-md-8";

$events = new Collection();

?>
		<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('css/hover.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('css/font-awesome.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{ url('css/pikaday.min.css') }}"/>

	<link rel="stylesheet" type="text/css" href="{{url('css/css.css')}}"/>

	<title>Kine | @section('title') Accueil @show </title>
</head>
<body>

<header>
	<nav class="navbar navbar-default  navbar-fixed-top ">
		<div class="container-fluid">
			<div id="nav-" class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				@if(isAdminZone())
					<a class="navbar-brand" href="/admin">La Santé en Mouvement</a>
				@else
					<a class="navbar-brand" href="/">La Santé en Mouvement</a>
				@endif
			</div>

			<div id="navbar" class="collapse navbar-collapse">

				<ul class="nav navbar-nav navbar-right">


					@include('layouts.parts.nav', ['nav' => [
						//['id' => 'nav-', 'href' => '/', 'html' => 'Accueil'],
						['id' => 'nav-qui-sommes-nous', 'href' => 'qui-sommes-nous', 'html' => 'Qui sommes-nous'],
						['id' => 'nav-nos-competences', 'href' => 'nos-competences', 'html' => 'Nos compétences'],
						['id' => 'nav-articles', 'href' => 'articles', 'html' => 'Articles'],
						['id' => 'nav-news', 'href' => 'news', 'html' => 'L\'actu'],
						//['id' => 'nav-galerie', 'href' => 'galerie', 'html' => 'Galerie'],
						['id' => 'nav-cours', 'href' => 'cours', 'html' => 'Les cours'],
					]])

					@if(Auth::check())
						@include('layouts.parts.dropdown', compact('nbOfNotifications'))
					@else
						<li id="nav-login" data-toggle="tooltip" data-placement="bottom" title="Se connecter" class="hvr-underline-from-center">
							<a class="glyphicon glyphicon-log-in" href="{{ url('connexion') }}"></a>
						</li>
					@endif

				</ul>
			</div>
		</div>
		<hr class="border">
	</nav>

	<div id="banner">
		<div class="col-md-12">
			<img src="{{url('img/logo.jpg')}}" alt="" class="img-banner">
		</div>
		{{--<div class="panel banner-panel">--}}
		{{--<div id="banner-content">--}}
		{{--<img class="logo" src="{{url('/img/logo.jpg')}}" alt="Logo du cabinet">--}}
		{{--</div>--}}
		{{--</div>--}}
	</div>

	<noscript>
		Ce site nécessite d'activer JavaScript pour fonctionner correctement.
	</noscript>

</header>

@include('flash::message')


<div class="container-fluid page-content">
	<div class="content {{ $contentBootstrapClassCol }}">
		<div class="inner">
			@yield('content')
		</div>
	</div>

	<aside class="col-md-3">
		<section class="content">
			<div class="inner aside-inner-img">
				<img src="{{ url('img/logo.jpg') }}" alt="">
			</div>
		</section>

		<section class="content">
			<div class="inner">
				<section class="networks">
					<h1>Suivez-nous !</h1>
					<a href="#"><img class="network-logo" src="/img/fb-logo.png" alt=""></a>
					<a href="#"><img class="network-logo" src="/img/gplus-logo.png" alt=""></a>
					<a href="#"><img class="network-logo" src="/img/twitter-logo.png" alt=""></a>
					<a href="#"><img class="network-logo" src="/img/yt-logo.png" alt=""></a>
				</section>
			</div>
		</section>

		{{--@if(!$isCurrentPageHomePage)--}}
		<section class="content">
			<div class="inner">
				<div class="lastest-news">
					<h1>Dernières news
						@if(isAdmin())
							<a data-toggle="tooltip" data-placement="left" title="Ajouter une news" href="#" {{--href="{{ url('news/creer') }}"--}}
							class="absolute-right create-new create-news glyphicon glyphicon-plus btn-hover"></a>
						@endif
					</h1>
					@if($template_news->count() > 0)
						@foreach($template_news as $n)
							<a href="/news/{{$n->id}}">{{$n->title}}</a>
							<p class="date">{{$n->published_at->format('d/m/Y')}}</p>
						@endforeach

						<a href="/news" align="right" class="see-all"><p>Tout voir <span class="glyphicon glyphicon-arrow-right"></span></p></a>
					@else
						<p>Aucune news récente.</p>
					@endif

				</div>

			</div>
		</section>
		<section class="content">
			<div class="inner">
				<div class="incoming-events">
					<h1>Événements à venir
						@if(isAdmin())
							<a data-toggle="tooltip" data-placement="left" title="Ajouter un événement" href="{{ url('evenements/creer') }}"
							   class="absolute-right create-new create-event glyphicon glyphicon-plus btn-hover"></a>
						@endif
					</h1>
					@if($template_events->count() > 0)
						@foreach($events as $e)
							<a data-toggle="tooltip" data-placement="top"
							   title="{{($today = $e->start->isToday()) ? 'Cet événement à lieu aujourd\'hui !' : 'Cliquez ici pour en savoir plus.'}}"
							   {{ $today ? 'class=today' : '' }}
							   href="/evenements/{{$e->id}}">{{$e->name}}
							</a>
							<p class="date {{ $today ? 'today' : '' }} ">
								{{--                                 @if($e->start->dayOfYear == $e->end->dayOfYear)
																	Le {{$e->start->format('d/m/Y\, \d\e H:i').' à '.$e->end->format('H:i')}}
																@else
																	Du {{$e->start->format('d/m').' au '.$e->end->format('d/m Y').', de '.$e->start->format('H:i').' à '.$e->end->format('H:i')}}
																@endif --}}
								Début : {{ $e->start->format('d/m/Y \à H:i') }} <br/>Fin : {{ $e->end->format('d/m/Y \à H:i') }}
							</p>
						@endforeach

						<a href="/evenements" align="right" class="see-all"><p>Tout voir <span class="glyphicon glyphicon-arrow-right"></span></p></a>
					@else
						<p>Aucun événement à venir.</p>
					@endif

				</div>
			</div>
		</section>
	</aside>
	{{--@endif--}}
</div>


@include('layouts.app.footer', $footer_doctors)


{{--<script src="{{ url('/js/jquery.min.js') }}"></script>--}}
<script
		src="http://code.jquery.com/jquery-3.2.1.min.js"
		integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
		crossorigin="anonymous">
</script>
<script src="{{ url('/js/bootstrap.min.js') }}"></script>
<script src="{{ url('/js/bootbox.min.js') }}"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=6dsidl73nkp1p71n04g9rr7dieh5e1whc8kp1ju40t4wzgn4"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>

@if(JsVar::getVars() != null && !empty(JsVar::getVars()))
	<div id="js-vars-relayer">
		@foreach(JsVar::getVars() as $var)
			<span hidden data-var-name="{{ $var->getName() }}"> {{ $var->getJson() }} </span>
		@endforeach
	</div>
@endif

<script src="{{ url('/js/app.js') }}"></script>

@yield('js')

</body>
</html>