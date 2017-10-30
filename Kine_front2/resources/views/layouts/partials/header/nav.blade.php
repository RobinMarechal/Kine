<nav class="navbar navbar-expand-md navbar-light bg-white fixed-top">
	@include("layouts.partials.header.nav.left")

	<div class="collapse navbar-collapse justify-content-end" id="navbarsExampleDefault">
		@include("layouts.partials.header.nav.menus", compact('nbOfNotifications'))
	</div>
</nav>