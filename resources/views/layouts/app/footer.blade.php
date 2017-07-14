<footer class="container-fluid">
	<div class="row">
		<div class="footer-address col-lg-4">
			<h3>Cabinet de kinésithérapie</h3>
			<hr class="footer-sub-title">
			<a data-toggle="tooltip" data-placement="top" title="Voir l'adresse dur Google Maps" href="https://www.google.fr/maps/place/2+Rue+Fosse+de+Meule,+45100+Orl%C3%A9ans/@47
		.8888859,1.8946489,15
		.75z/data=!4m5!3m4!1s0x47e4e4df563f967f:0xab242801d95ec938!8m2!3d47.8909425!4d1.8983722">
				<i class="fa fa-map-marker" aria-hidden="true"></i>
				2 Rue Fosse de Meule, 45100 Orléans
			</a>
			<br>
			<p data-toggle="tooltip" data-placement="top" title="Numéro de téléphone du cabinet" class="phone">
				<i class="fa fa-phone" aria-hidden="true"></i>
				02 30 68 24 56
			</p>

			<br>

			<h3>Autres contacts </h3>
			<hr class="footer-sub-title">
			@forelse($footer_other_contacts as $c)
				<p @if(isset($c->name)) data-toggle="tooltip" data-placement="top" title="{{ $c->name }}" @endif class="footer_contact">
					<i class="fa {{ $c->getFontAwesomeIconClass() }}"></i>
					{!! $c->getFormattedValue() !!}
				</p> <br>
			@empty
				<p>-</p>
			@endforelse
		</div>

		<div class="col-lg-4">

			<h3>Les kinésithérapeutes</h3>
			<hr class="footer-sub-title">
			<div class="footer-doctors">
				@forelse($footer_doctors as $d)
					<div class="footer-doctor">
						<p class="footer-doctor-name">
							<b>
								{{ $d->name }}
							</b>
						</p>
						<br>


						<p>Horaires : {{ getTimeString($d->starts_at) }} - {{ getTimeString($d->ends_at) }}</p>
						<br>

						@forelse($d->contacts as $c)
							<p class="footer-contact">
								<i class="fa {{ $c->getFontAwesomeIconClass() }}"></i>
								{!! $c->getFormattedValue() !!}
							</p>
							<br>
						@empty
						@endforelse
						<br>
					</div>
				@empty
					<p>-</p>
				@endforelse

			</div>
		</div>

		<div class="col-lg-4">
			<h3>Utilisateur</h3>
			<hr class="footer-sub-title">

			<a href="">Connexion</a> <br>
			<a href="">Inscription</a> <br>
			<a href="">Connexion avec Facebook</a> <br>
			<a href="">Déconnexion</a>

			<br>

			<h3>Autres</h3>
			<hr class="footer-sub-title">

			<a href="">A propos</a> <br>
			<a href="">Signaler un bug</a> <br>
			<a href="">Conditions générales d'utilisations</a> <br>
			<p>Site web réalisé par <a href=""> Robin Maréchal</a></p>

		</div>
	</div>
</footer>