<ul class="navbar-nav bd-navbar-nav flex-row justify-content-end">

	@include('layouts.partials.header.nav.menus.include', ['nav' => [
		['id' => 'nav-', 'href' => '/', 'html' => 'Accueil'],
		//['id' => 'nav-qui-sommes-nous', 'href' => 'qui-sommes-nous', 'html' => 'Qui sommes-nous'],
		['id' => 'nav-nos-competences', 'href' => 'nos-competences', 'html' => 'Nos compétences'],
		['id' => 'nav-articles', 'href' => 'articles', 'html' => 'Articles'],
		['id' => 'nav-news', 'href' => 'news', 'html' => 'L\'actu'],
		['id' => 'nav-galerie', 'href' => 'galerie', 'html' => 'Galerie'],
		['id' => 'nav-cours', 'href' => 'cours', 'html' => 'Les cours'],
	]])

	@if(!Auth::check())
		@include('layouts.partials.header.nav.menus.dropdown', compact('nbOfNotifications'))
	@else
		<li id="nav-login" class="nav-item" data-toggle="tooltip" data-placement="bottom" title="Se connecter">
			<a href="{{route('login.showLoginForm')}}" class="nav-link text-capitalize">
				<i class="fa fa-sign-in" aria-hidden="true"></i>
			</a>
		</li>
	@endif
</ul>