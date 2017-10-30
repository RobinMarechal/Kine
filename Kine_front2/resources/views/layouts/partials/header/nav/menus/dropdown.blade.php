<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
	   aria-expanded="false" aria-haspopup="true">
		<span class="fa fa-user-o">
			@if($nbOfNotifications > 0)
				<span class="nb-of-notifs nb-of-notifs-user">{{ $nbOfNotifications }}</span>
			@endif
		</span>
		<span class="caret"></span>
	</a>
	<div class="dropdown-menu">
		<span id="nav-profile" class="dropdown-item">
{{--			{{Auth::user()->name}}--}}
		</span>
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" id="nav-notifications" href="{{ url('notifications') }}" data-toggle="tooltip" data-placement="left" title="Voir les notifications">
			<span class="fa fa-bell-o position-relative">@if($nbOfNotifications > 0)
					<span class="nb-of-notifs">{{ $nbOfNotifications }}</span>
				@endif
			</span>
			Notifications
		</a>
		@if(true)
			@if(isAdminZone())
				<a id="nav-admin" class="dropdown-item" data-toggle="tooltip" data-placement="left" title="Quitter la zone d'administration" href="{{ url('/') }}">
					<i class="fa fa-home"></i>
					Accueil
				</a>
			@else
				<a id="nav-admin" class="dropdown-item" data-toggle="tooltip" data-placement="left" title="Accéder à la zone d'administration" href="{{ url('admin') }}">
					<i class="fa fa-cog" aria-hidden="true"></i>
					Administration
				</a>
			@endif

		@endif
		<a id="nav-logout" class="dropdown-item" data-toggle="tooltip" data-placement="left" title="Se déconnecter" href="{{ url('deconnexion') }}">
			<i class="fa fa-sign-out" aria-hidden="true"></i>
			Se déconnecter
		</a>
	</div>
</li>