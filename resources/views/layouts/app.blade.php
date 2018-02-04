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

$events = Template::getEvents();
//$events = new Collection();

?>
		<!DOCTYPE html>
<html>

@include('layouts.parts.head', ['title' => 'Accueil'])

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

	@include('layouts.parts.banner')

	@include('layouts.parts.noscript')

</header>

@include('flash::message')


<div class="container-fluid page-content">
	<div class="content {{ $contentBootstrapClassCol }}">
		<div class="inner">
			@yield('content')
		</div>
	</div>

	<aside class="col-md-3">

		@include('layouts.parts.aside.logo')
		@include('layouts.parts.aside.news')
		@include('layouts.parts.aside.events')

	</aside>
</div>
@include('layouts.app.footer', $footer_doctors)
@include('layouts.parts.js')
</body>
</html>