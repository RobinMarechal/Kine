<section class="content">
    <div class="inner">
        <div class="incoming-events">
            <h1>Événements à venir
                @if(isAdmin())
                    <a data-toggle="tooltip" data-placement="left" data-namespace="events" title="Ajouter un événement" href="{{ url('evenements/creer') }}"
                       class="create-data absolute-right create-new create-event glyphicon glyphicon-plus btn-hover"></a>
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
                        {{--                                 @if($e->start->dayOfYear == $e->end->dayOfYear)
                                                            Le {{$e->start->format('d/m/Y\, \d\e H:i').' à '.$e->end->format('H:i')}}
                                                        @else
                                                            Du {{$e->start->format('d/m').' au '.$e->end->format('d/m Y').', de '.$e->start->format('H:i').' à '.$e->end->format('H:i')}}
                                                        @endif --}}
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