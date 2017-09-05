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
		<li id="nav-notifications" data-toggle="tooltip" data-placement="left" title="Voir les notifications">
			<a href="{{ url('notifications') }}">
				@if($nbOfNotifications > 0)
					<span class="nb-of-notifs">{{ $nbOfNotifications }}</span>
				@endif
				<span class="glyphicon glyphicon-bell"></span>
				Notifications
			</a>
		</li>
		@if(isAdmin())


			@if(isAdminZone())
				<li id="nav-admin" data-toggle="tooltip" data-placement="left" title="Quitter la zone d'administration">
					<a href="{{ url('/') }}">
						<span class="glyphicon-cog glyphicon"></span>
						Accueil
					</a>
				</li>
			@else
				<li id="nav-admin" data-toggle="tooltip" data-placement="left" title="Accéder à la zone d'administration">
					<a href="{{ url('admin') }}">
						<span class="glyphicon-cog glyphicon"></span>
						Administration
					</a>
				</li>
			@endif

		@endif
		<li id="nav-logout" data-toggle="tooltip" data-placement="left" title="Se déconnecter">
			<a href="{{ url('deconnexion') }}">
				<span class="glyphicon-log-out glyphicon"></span>
				Se déconnecter
			</a>
		</li>
	</ul>
</li>