{{--<?php--}}
{{--$banner_content = App\Content::where('name', 'banner_content')->first();--}}
{{--$news = App\News::whereNull('team_id')->where('validated', '1')->where('published_at', '<=', DB::raw('NOW()'))->orderBy('published_at', 'DESC')->limit(5)->get();--}}
{{--$events = App\Event::whereNull('team_id')->where('validated', '1')->where('start', '>=', DB::raw('NOW()'))->orderBy('start', 'ASC')->limit(5)->get();--}}

{{--if($logged = Auth::check())--}}
{{--{--}}
    {{--$nbOfNotifications = Auth::user()->getNbOfUnseenNotifications();--}}
{{--}--}}
{{--?>--}}

        {{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}
    {{--<meta charset="utf-8">--}}
    {{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}
    {{--<link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.css')}}" />--}}
    {{--<link rel="stylesheet" type="text/css" href="{{url('css/hover.min.css')}}" />--}}
    {{--<link rel="stylesheet" type="text/css" href="{{url('/js/jQueryUI/jquery-ui.min.css')}}"></link>--}}

    {{-- <link rel="stylesheet" type="text/css" href="{{url('/js/CKeditor/contents.css')}}" /> --}}
    {{--<title>BDA | @section('title') BDA Polytech Tours @show </title>--}}

    {{--<base href="/">--}}
{{--</head>--}}
{{--<body ng-app="app">--}}
{{--<header>--}}

    {{--<nav class="navbar navbar-default navbar-fixed-top">--}}
        {{--<div class="container-fluid">--}}
            {{--<div class="navbar-header">--}}
                {{--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">--}}
                    {{--<span class="sr-only">Toggle navigation</span>--}}
                    {{--<span class="icon-bar"></span>--}}
                    {{--<span class="icon-bar"></span>--}}
                    {{--<span class="icon-bar"></span>--}}
                {{--</button>--}}
                {{--<a class="navbar-brand" href="/">Bureau des Arts de Polytech Tours</a>--}}
            {{--</div>--}}

            {{--<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">--}}

                {{--<ul class="nav navbar-nav navbar-right" ng-init="home='active'">--}}
                    {{--<li id="nav-home" class="hvr-underline-from-center"><a href="{{ url('/') }}">Accueil</a></li>--}}
                    {{--<li id="nav-teams" class="hvr-underline-from-center"><a href="{{ url('teams') }}"">Les Teams</a></li>--}}
                    {{--<li id="nav-news" class="hvr-underline-from-center"><a href="{{ url('news') }}"">L'Actu</a></li>--}}
                    {{--<li id="nav-events" class="hvr-underline-from-center"><a href="{{ url('events') }}"">Événements</a></li>--}}
                    {{--<li id="nav-staff" class="hvr-underline-from-center"><a href="{{ url('staff') }}"">Le Staff</a></li>--}}
                    {{--<li id="nav-gallery" class="hvr-underline-from-center"><a href="{{ url('gallery') }}"">Galerie d'Images</a></li>--}}

                    {{--@if(Auth::check())--}}
                        {{--<li class="dropdown">--}}
                            {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">--}}
                                {{--<span class="glyphicon glyphicon-user"></span>--}}
                                {{--<span class="caret"></span>--}}
                            {{--</a>--}}
                            {{--<ul class="dropdown-menu" role="menu">--}}
                                {{--<li id="nav-profile" title="Consultez votre profile">--}}
                                    {{--<a href="{{ url('users/show/'. Auth::user()->id) }}">--}}
                                        {{--<span class="glyphicon glyphicon-user"></span>--}}
                                        {{--{{Auth::user()->first_name . ' ' . Auth::user()->last_name}}--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li id="nav-notifications" title="Voir les notifications">--}}
                                    {{--<a href="{{ url('notifications') }}">--}}
                                        {{--@if($nbOfNotifications > 0)--}}
                                            {{--<span class="nb-of-notifs">{{ $nbOfNotifications }}</span>--}}
                                        {{--@endif--}}
                                        {{--<span class="glyphicon glyphicon-bell"></span>--}}
                                        {{--Notifications--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li id="nav-logout" title="Se déconnecter">--}}
                                    {{--<a href="{{ url('auth/logout') }}">--}}
                                        {{--<span class="glyphicon-log-out glyphicon" ></span>--}}
                                        {{--Se déconnecter--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                    {{--@else--}}
                        {{--<li id="nav-login" title="Se connecter" class="hvr-underline-from-center">--}}
                            {{--<a class="glyphicon glyphicon-log-in" href="{{ url('auth/login') }}"></a>--}}
                        {{--</li>--}}
                    {{--@endif--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<hr class="border"></hr>--}}
    {{--</nav>--}}

    {{--<div id="banner">--}}
        {{--<div class="panel banner-panel content-editable">--}}
            {{-- <div ng-show="user.check != 1" title="Cliquez ici pour modifier le contenu" class="glyphicon glyphicon-pencil edit-content"></div> --}}
            {{--{!! printButtonContent($banner_content->name, ['id' => 'banner-content-btn'], 'btn-edit-banner') !!}--}}

            {{--<div id="banner-content" data-name="{{ $banner_content->name }}">--}}
                {{--<h1>{{ $banner_content->title }}</h1>--}}
                {{--<p>{{ $banner_content->content }}</p>--}}
            {{--</div>--}}

        {{--</div>--}}
    {{--</div>--}}

    {{--<noscript>--}}
        {{--Ce site nécessite d'activer JavaScript pour fonctionner correctement.--}}
    {{--</noscript>--}}

{{--</header>--}}

{{--@include('flash::message')--}}

{{--<div class="container-fluid page-content">--}}
    {{--<div class="content col-lg-8">--}}
        {{--<div class="inner">--}}
            {{--@yield('content')--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<aside class="content col-lg-4">--}}
        {{--<div class="inner">--}}
            {{--<section class="social-networks">--}}
                {{--<h1>Suivez-nous</h1>--}}
                {{--<div class="logos">--}}
                    {{--<a target="_BLANK" href="https://www.facebook.com/BDA-Polytech-Tours-233930700284519/"><img src="{{url('img/fb-logo.png')}}"></a>--}}
                    {{--<a target="_BLANK" href="https://www.youtube.com/channel/UCM9GF7SHxbyUzQUT6eJDPlw"><img src="{{url('img/yt-logo.png')}}"></a>--}}
                {{--</div>--}}

            {{--</section>--}}

            {{--<hr class="separator">--}}

            {{--<section class="lastest-news">--}}
                {{--<h1>Dernières news--}}
                    {{--@if(Auth::check() && Auth::user()->level > 1)--}}
                        {{--<a title="Ajouter une news" href="{{ url('news/create') }}" class="create-new create-news glyphicon glyphicon-plus btn-hover"></a>--}}
                    {{--@endif--}}
                {{--</h1>--}}
                {{--@if($news->count() > 0)--}}
                    {{--@foreach($news as $n)--}}
                        {{--<a href="/news/show/{{$n->id}}">{{$n->title}}</a>--}}
                        {{--<p class="date">{{$n->published_at->format('d/m/Y')}}</p>--}}
                    {{--@endforeach--}}

                    {{--<a href="/news" align="right" class="see-all"><p>Tout voir <span class="glyphicon glyphicon-arrow-right"></span></p></a>--}}
                {{--@else--}}
                    {{--<p>Aucune news récente.</p>--}}
                {{--@endif--}}

            {{--</section>--}}

            {{--<hr class="separator">--}}

            {{--<section class="incoming-events">--}}
                {{--<h1>Événements à venir--}}
                    {{--@if(Auth::check() && Auth::user()->level > 1)--}}
                        {{--<a title="Ajouter un événement" href="{{ url('events/create') }}" class="create-new create-event glyphicon glyphicon-plus btn-hover"></a>--}}
                    {{--@endif--}}
                {{--</h1>--}}
                {{--@if($events->count() > 0)--}}
                    {{--@foreach($events as $e)--}}
                        {{--<a--}}
                                {{--title="{{($today = $e->start->isToday()) ? 'Cet événement à lieu aujourd\'hui !' : 'Cliquez ici pour en savoir plus.'}}"--}}
                                {{--{{ $today ? 'class=today' : '' }}--}}
                                {{--href="/events/show/{{$e->id}}">{{$e->name}}--}}
                        {{--</a>--}}
                        {{--<p class="date {{ $today ? 'today' : '' }} ">--}}
                            {{--                                 @if($e->start->dayOfYear == $e->end->dayOfYear)--}}
                                                                {{--Le {{$e->start->format('d/m/Y\, \d\e H:i').' à '.$e->end->format('H:i')}}--}}
                                                            {{--@else--}}
                                                                {{--Du {{$e->start->format('d/m').' au '.$e->end->format('d/m Y').', de '.$e->start->format('H:i').' à '.$e->end->format('H:i')}}--}}
                                                            {{--@endif --}}
                            {{--Début : {{ $e->start->format('d/m/Y \à H:i') }} <br />Fin : {{ $e->end->format('d/m/Y \à H:i') }}--}}
                        {{--</p>--}}
                    {{--@endforeach--}}

                    {{--<a href="/events" align="right" class="see-all"><p>Tout voir <span class="glyphicon glyphicon-arrow-right"></span></p></a>--}}
                {{--@else--}}
                    {{--<p>Aucun événement à venir.</p>--}}
                {{--@endif--}}

            {{--</section>--}}
        {{--</div>--}}
    {{--</aside>--}}
{{--</div>--}}



{{--@yield('js')--}}

{{--</body>--}}
{{--</html>--}}

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<script src="{{url('test.mix.jsx.js')}}"></script>
</body>
</html>