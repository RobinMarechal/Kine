@include("layouts.partials.header", compact('nbOfNotifications'))

<div class="page">
	@yield('content')
</div>

@include("layouts.partials.footer", compact('footer_doctors', 'footer_doctors'))
