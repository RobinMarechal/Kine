<footer class="jumbotron bg-transparent shadow-top">
	<div class="row">
		<div class="col-md-4">
			<h4>Cabinet de kinésithérapie</h4>
			<hr class="footer-sub-title">
			<p>
				<a data-toggle="tooltip" target="_blank" data-placement="top" title="Voir l'adresse dur Google Maps" href="https://www.google.fr/maps/place/2+Rue+Fosse+de+Meule,
			+45100+Orl%C3%A9ans/@47
		.8888859,1.8946489,15
		.75z/data=!4m5!3m4!1s0x47e4e4df563f967f:0xab242801d95ec938!8m2!3d47.8909425!4d1.8983722">
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					2 Rue Fosse de Meule, 45100 Orléans
				</a>
			</p>

			<p data-toggle="tooltip" data-placement="top" title="Numéro de téléphone du cabinet" class="phone">
				<i class="fa fa-phone" aria-hidden="true"></i>
				<a href="tel:+33230682456">02 30 68 24 56</a>
			</p>
		</div>

		<div class="col-md-4">
			<h4>Les kinés</h4>
			<hr>
			@forelse($footer_doctors as $d)
				<p><a href="#">{{ $d->name }}</a></p>
			@empty
			@endforelse
		</div>


		<div class="col-md-4">
			<h4>Utilisateur</h4>
			<hr>
			@if(Auth::guest())
				<p><a href="{{ route('login.showLoginForm') }}">Connexion</a></p>
				<p><a href="{{ route('register.showRegistrationForm') }}">Inscription</a></p>
			@else
				<p><a href="{{ route('login.logout') }}">Déconnexion</a></p>
			@endif

			<br>
				<h4>Autres</h4>
				<hr class="footer-sub-title">

				<p><a href="{{ route('about') }}">A propos</a></p>
				<p><a href="{{ route('notifyBug') }}">Signaler un bug</a></p>
				<p><a href="{{ route('guc') }}">Conditions générales d'utilisations</a></p>
				<p><a target="_blank" href="https://www.linkedin.com/in/robinmarechal/"> Site web réalisé par Robin Maréchal</a></p>
		</div>
	</div>
</footer>

<script src="{{url('/js/app.js')}}"></script>

</body>