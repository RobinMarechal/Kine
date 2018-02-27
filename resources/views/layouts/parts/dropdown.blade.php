<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
       aria-expanded="false" aria-haspopup="true">
        @if($nbOfNotifications > 0)
            <span class="nb-of-notifs nb-of-notifs-user">{{ $nbOfNotifications }}</span>
        @endif
        <i class="fas fa-user"> </i>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li id="nav-profile">
            <a class="dropdown-menu--username">
                {{Auth::user()->name}}
            </a>
        </li>
        <div class="divider"></div>
        <li id="nav-notifications" data-toggle="tooltip" data-placement="left" title="Voir les notifications">
            <a href="{{ url('notifications') }}">
                @if($nbOfNotifications > 0)
                    <span class="nb-of-notifs">{{ $nbOfNotifications }}</span>
                @endif
                <span class="fas fa-bell list-icon"></span>
                <span class="dropdown-menu--link">Notifications</span>
            </a>
        </li>
        @if(isAdmin())


            @if(isAdminZone())
                <li id="nav-admin" data-toggle="tooltip" data-placement="left" title="Quitter la zone d'administration">
                    <a href="{{ url('/') }}">
                        <span class="fas fa-home list-icon"></span>
                        <span class="dropdown-menu--link">Accueil</span>
                    </a>
                </li>
            @else
                <li id="nav-admin" data-toggle="tooltip" data-placement="left"
                    title="Accéder à la zone d'administration">
                    <a href="{{ url('admin') }}">
                        <span class="fa-cog fas list-icon"></span>
                        <span class="dropdown-menu--link">Administration</span>
                    </a>
                </li>
            @endif

        @endif
        <li id="nav-logout" data-toggle="tooltip" data-placement="left" title="Se déconnecter">
            <a href="{{ url('deconnexion') }}">
                <span class="fa-sign-out-alt fas list-icon"></span>
                <span class="dropdown-menu--link"> Se déconnecter</span>
            </a>
        </li>
    </ul>
</li>