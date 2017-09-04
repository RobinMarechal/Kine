<?php

use Illuminate\Database\Eloquent\Collection;

$nbOfNotifications = 0;

$isCurrentPageHomePage = false;
if (Route::currentRouteName() === "home" || Route::currentRouteName() === "home") {
	$isCurrentPageHomePage = true;
}
$contentBootstrapClassCol = "col-lg-9";
//$contentBootstrapClassCol = $isCurrentPageHomePage ? "col-lg-12" : "col-lg-8";

$events = new Collection();

?>
		<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('css/hover.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('css/font-awesome.min.css')}}"/>

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/css/pikaday.min.css"/>

	<link rel="stylesheet" type="text/css" href="{{url('css/css.css')}}"/>

	<title>Kine | @section('title') Accueil @show </title>
</head>
<body>

<header>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
						data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">Kiné - Administration</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

				<ul class="nav navbar-nav navbar-right" ng-init="home='active'">
					<li id="nav-" class="hvr-underline-from-center"><a href="{{ url('/') }}">Accueil</a></li>
					<li id="nav-qui-sommes-nous" class="hvr-underline-from-center"><a href="{{ url('qui-sommes-nous') }}">Qui sommes nous</a></li>
					<li id="nav-nos-competences" class="hvr-underline-from-center"><a href="{{ url('nos-competences') }}">Nos compétences</a></li>
					<li id="nav-articles" class="hvr-underline-from-center"><a href="{{ url('articles') }}">Articles</a></li>
					<li id="nav-news" class="hvr-underline-from-center"><a href="{{ url('news') }}">L'actu</a></li>
					<li id="nav-galerie" class="hvr-underline-from-center"><a href="{{ url('galerie') }}">Galerie</a></li>
					<li id="nav-cours" class="hvr-underline-from-center"><a href="{{ url('cours') }}">Les cours</a></li>

					@if(Auth::check())
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
							   aria-expanded="false">
								<span class="glyphicon glyphicon-user">
									@if($nbOfNotifications > 0)
										<span class="nb-of-notifs nb-of-notifs-user">{{ $nbOfNotifications }}</span>
									@endif
								</span>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li id="nav-profile">
									<a>
										<span class="glyphicon glyphicon-user"></span>
										{{Auth::user()->name}}
									</a>
								</li>
								<li id="nav-notifications" data-toggle="tooltip" data-placement="left" title="Voir les notifications">
									<a href="{{ url('notifications') }}">
										@if($nbOfNotifications > 0)
											<span class="nb-of-notifs">{{ $nbOfNotifications }}</span>
										@endif
										<span class="glyphicon glyphicon-bell"></span>
										Notifications
									</a>
								</li>
								@if(isAdmin())
									<li id="nav-admin" data-toggle="tooltip" data-placement="left" title="Accéder à la zone d'administration">
										<a href="{{ url('admin') }}">
											<span class="glyphicon-cog glyphicon"></span>
											Administration
										</a>
									</li>
								@endif
								<li id="nav-logout" data-toggle="tooltip" data-placement="left" title="Se déconnecter">
									<a href="{{ url('deconnexion') }}">
										<span class="glyphicon-log-out glyphicon"></span>
										Se déconnecter
									</a>
								</li>
							</ul>
						</li>
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
		<div class="col-lg-12">
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

	{{--@if(!$isCurrentPageHomePage)--}}
	<aside class="content col-lg-3">
		<div class="inner">
			<section class="lastest-news">
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

			</section>

			<hr class="separator">

			<section class="incoming-events">
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

			</section>
		</div>
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
{{--<script src="{{ url('/js/CKeditor/ckeditor.js') }}"></script>--}}
{{--<script src="//cdn.ckeditor.com/4.7.1/basic/ckeditor.js"></script>--}}
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=6dsidl73nkp1p71n04g9rr7dieh5e1whc8kp1ju40t4wzgn4"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>


<script src="{{ url('/js/app.js') }}"></script>

@yield('js')

</body>
</html>