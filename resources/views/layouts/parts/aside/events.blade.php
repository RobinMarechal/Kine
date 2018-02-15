{{--

<section class="content">
    <div class="inner">
        <div class="incoming-events">
            <h1>Événements à venir
                @if(isAdmin())
                    {!! addButton(\App\Event::class, ['title' => 'Créer un événement', 'data-placement' => 'left']) !!}
                @endif
            </h1>
            @if($template_events->count() > 0)
                @foreach($events as $e)
                    <a data-toggle="tooltip" data-placement="top"
                       title="{{($today = $e->starts_at->isToday()) ? 'Cet événement à lieu aujourd\'hui !' : 'Cliquez ici pour en savoir plus.'}}"
                       {{ $today ? 'class=today' : '' }}
                       href="/evenements/{{$e->id}}">{{$e->name}}
                    </a>
                    <p class="date {{ $today ? 'today' : '' }} ">
                        Début : {{ $e->starts_at->format('d/m/Y \à H:i') }} <br/>Fin : {{ $e->ends_at->format('d/m/Y \à H:i') }}
                    </p>
                @endforeach

                <a href="/evenements" align="right" class="see-all"><p>Tout voir <span class="glyphicon glyphicon-arrow-right"></span></p></a>
            @else
                <p>Aucun événement à venir.</p>
            @endif

        </div>
    </div>
</section>

--}}