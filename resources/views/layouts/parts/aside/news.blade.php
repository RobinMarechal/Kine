<section class="content">
    <div class="inner">
        <div class="lastest-news">
            <h1>Dernières news
                @if(isAdmin())
                    {!! addButton(\App\News::class, ['title' => 'Ajouter une news', 'data-placement' => 'left']) !!}
                    {{--<a data-toggle="tooltip" data-placement="left" data-namespace="news" title="Ajouter une news" href="#" --}}{{--href="{{ url('news/creer') }}"--}}
                    {{--class="create-data  absolute-right create-new create-news glyphicon glyphicon-plus btn-hover"></a>--}}
                    {{--<a data-toggle="tooltip" data-placement="left" data-namespace="events" title="Ajouter un événement" href="{{ url('evenements/creer') }}"--}}
                       {{--class="create-data absolute-right create-new create-event glyphicon glyphicon-plus btn-hover"></a>--}}
                @endif
            </h1>
            @if($template_news->count() > 0)
                @foreach($template_news as $n)
                    <a href="/news/{{$n->id}}">{{$n->title}}</a>
                    <p class="date">{{$n->published_at->format('d/m/Y')}}</p>
                @endforeach

                <a href="/news" align="right" class="see-all"><p>Tout voir <span class="glyphicon glyphicon-arrow-right"></span></p></a>
            @else
                <p>Aucune news récente.</p>
            @endif

        </div>

    </div>
</section>