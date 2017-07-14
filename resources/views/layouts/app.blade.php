<?php

use Illuminate\Database\Eloquent\Collection;

$nbOfNotifications = 0;

$isCurrentPageHomePage = false;
if (Route::currentRouteName() === "home" || Route::currentRouteName() === "home") {
	$isCurrentPageHomePage = true;
}
$contentBootstrapClassCol = "col-lg-8";
//$contentBootstrapClassCol = $isCurrentPageHomePage ? "col-lg-12" : "col-lg-8";

$news = new Collection();
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
				<a class="navbar-brand" href="/">Kiné</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

				<ul class="nav navbar-nav navbar-right" ng-init="home='active'">
					<li id="nav-home" class="hvr-underline-from-center"><a href="{{ url('/') }}">Accueil</a></li>
					<li id="nav-who-are-we" class="hvr-underline-from-center"><a href="{{ url('teams') }}">Qui sommes nous</a></li>
					<li id="nav-skills" class="hvr-underline-from-center"><a href="{{ url('news') }}">Nos compétences</a></li>
					<li id="nav-articles" class="hvr-underline-from-center"><a href="{{ url('staff') }}">Articles</a></li>
					<li id="nav-news" class="hvr-underline-from-center"><a href="{{ url('gallery') }}">L'actu</a></li>
					<li id="nav-gallery" class="hvr-underline-from-center"><a href="{{ url('events') }}">Galerie</a></li>
					<li id="nav-courses" class="hvr-underline-from-center"><a href="{{ url('events') }}">Les cours</a></li>

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
								<li id="nav-notifications" title="Voir les notifications">
									<a href="{{ url('users/notifications') }}">
										@if($nbOfNotifications > 0)
											<span class="nb-of-notifs">{{ $nbOfNotifications }}</span>
										@endif
										<span class="glyphicon glyphicon-bell"></span>
										Notifications
									</a>
								</li>
								<li id="nav-logout" title="Se déconnecter">
									<a href="{{ url('logout') }}">
										<span class="glyphicon-log-out glyphicon"></span>
										Se déconnecter
									</a>
								</li>
							</ul>
						</li>
					@else
						<li id="nav-login" title="Se connecter" class="hvr-underline-from-center">
							<a class="glyphicon glyphicon-log-in" href="{{ url('login') }}"></a>
						</li>
					@endif
				</ul>
			</div>
		</div>
		<hr class="border"></hr>
	</nav>

	<div id="banner">
		{{--<div class="panel banner-panel content-editable">--}}
		{{--<div ng-show="user.check != 1" title="Cliquez ici pour modifier le contenu" class="glyphicon glyphicon-pencil edit-content"></div> --}}
		{{--{!! printButtonContent($banner_content->name, ['id' => 'banner-content-btn'], 'btn-edit-banner') !!}--}}

		{{--<div id="banner-content" data-name="{{ $banner_content->name }}">--}}
		{{--<h1>{{ $banner_content->title }}</h1>--}}
		{{--<p>{{ $banner_content->content }}</p>--}}
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
		<aside class="content col-lg-4">
			<div class="inner">
				<section class="lastest-news">
					<h1>Dernières news
						@if(Auth::check() && Auth::user()->is_doctor)
							<a title="Ajouter une news" href="{{ url('news/create') }}"
							   class="create-new create-news glyphicon glyphicon-plus btn-hover"></a>
						@endif
					</h1>
					@if($news->count() > 0)
						@foreach($news as $n)
							<a href="/news/show/{{$n->id}}">{{$n->title}}</a>
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
						@if(Auth::check() && Auth::user()->is_doctor)
							<a title="Ajouter un événement" href="{{ url('events/create') }}"
							   class="create-new create-event glyphicon glyphicon-plus btn-hover"></a>
						@endif
					</h1>
					@if($events->count() > 0)
						@foreach($events as $e)
							<a
									title="{{($today = $e->start->isToday()) ? 'Cet événement à lieu aujourd\'hui !' : 'Cliquez ici pour en savoir plus.'}}"
									{{ $today ? 'class=today' : '' }}
									href="/events/show/{{$e->id}}">{{$e->name}}
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

						<a href="/events" align="right" class="see-all"><p>Tout voir <span class="glyphicon glyphicon-arrow-right"></span></p></a>
					@else
						<p>Aucun événement à venir.</p>
					@endif

				</section>
			</div>
		</aside>
	{{--@endif--}}
</div>


@include('layouts.app.footer', $footer_doctors)


<script src="{{ url('/js/jquery.min.js') }}"></script>
<script src="{{ url('/js/bootstrap.min.js') }}"></script>
<script src="{{ url('/js/bootbox.min.js') }}"></script>

<script src="{{ url('/js/CKeditor/ckeditor.js') }}"></script>

<script>

    var alerts = $('.alert').delay(2000).fadeOut(700, function () {
        $(this).remove();
    });

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

</body>
</html>