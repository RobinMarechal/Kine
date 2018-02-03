<footer class="container-fluid">
	<div class="row">
		<div class="footer-address col-md-4">
			<h3>Cabinet de kinésithérapie</h3>
			<hr class="footer-sub-title">
			<a data-toggle="tooltip" target="_blank" data-placement="top" title="Voir l'adresse dur Google Maps" href="https://www.google.fr/maps/place/2+Rue+Fosse+de+Meule,
			+45100+Orl%C3%A9ans/@47
		.8888859,1.8946489,15
		.75z/data=!4m5!3m4!1s0x47e4e4df563f967f:0xab242801d95ec938!8m2!3d47.8909425!4d1.8983722">
				<i class="fa fa-map-marker" aria-hidden="true"></i>
				2 Rue Fosse de Meule, 45100 Orléans
			</a>
			<br>
			<a target="_blank" href="tel:+33230682456" data-toggle="tooltip" data-placement="top" title="Numéro de téléphone du cabinet" class="phone">
				<i class="fa fa-phone" aria-hidden="true"></i>
				02 30 68 24 56
			</a>
			<br>
			@forelse($footer_other_contacts as $c)
				<p class="footer_contact">
					<i class="fa {{ $c->getFontAwesomeIconClass() }}"></i>
					{!! $c->getFormattedValue() !!}
				</p>
				<br>
			@empty
			
			@endforelse

			<div class="networks">
				<a href="#"><img class="network-logo" src="/img/fb-logo.png" alt=""></a>
				<a href="#"><img class="network-logo" src="/img/gplus-logo.png" alt=""></a>
				<a href="#"><img class="network-logo" src="/img/twitter-logo.png" alt=""></a>
				<a href="#"><img class="network-logo" src="/img/yt-logo.png" alt=""></a>
			</div>
		</div>

		<div class="col-md-4">

			<h3>Les kinésithérapeutes</h3>
			<hr class="footer-sub-title">
			<div class="footer-doctors">
				@forelse($footer_doctors as $d)
						<p class="footer-doctor-name" data-id="{{ $d->id }}">
								{{ $d->name }}
						</p>
						<br>
				@empty
					<p>-</p>
				@endforelse

			</div>
		</div>

		<div class="col-md-4">
			<h3>Liens Utiles</h3>
			<hr class="footer-sub-title">

			@if(Auth::guest())
				<a href="{{ url('connexion') }}">Connexion</a> <br>
				<a href="{{ url('inscription') }}">Inscription</a> <br>
			@else
				<a href="{{ url('deconnexion') }}">Déconnexion</a> <br>
			@endif

			<a href="{{ url('a-propos') }}">A propos</a> <br>
			<a href="{{ url('signaler-un-bug') }}">Signaler un bug</a> <br>
			<a href="{{ url('conditions-generales-d-utilisation') }}">Conditions générales d'utilisation</a> <br>
			<p>Site web réalisé par <a target="_blank" href="https://www.linkedin.com/in/robinmarechal/"> <b>Robin Maréchal</b></a></p>

		</div>
	</div>
</footer>