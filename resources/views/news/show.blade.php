@extends('layouts.app')

@section('title')
    {{ $news->title }}
@endsection

@section('content-header')
@endsection


@section('content')

    <div class="editable content-editable">
        @if(isAdmin())
            <div id="news-visibility-info" class="top-left-info"
                 @if(!$news->published_at->gt(new Carbon\Carbon())) hidden @endif >
                <i data-toggle="tooltip"
                   data-placement="top"
                   title="Cette news sera publiée le {{ $news->published_at->format('d/m/Y') }}."
                   data-title-template="Cette news sera publiée le {date}."
                   data-title-template-variable="date"
                   class="far fa-clock top-left-symbol">
                </i>
            </div>

            {!! editButton($news, ['title' => 'Modifier la news']) !!}
            {!! removeButton($news, ['title' => 'Supprimer la news', 'data-placement' => 'left']) !!}
        @endif

        <h1 id="news-title"> {{ $news->title }} </h1>
        <hr>
        <div id="news-content" class="news-content">
            {!! $news->content !!}
        </div>


        <p class="written-by" align="right">
            Publiée par {{$news->doctor->name}}, le
            <span id="news-published_at" class="news-published_at">
                {{$news->published_at->format('d/m/Y')}}
            </span>
        </p>
        <p class="written-by nb-of-views" align="right">
            Vue {{number_format($news->views, 0, '.', ' ')}} fois
        </p>

    </div>
@endsection


@section('js')

@endsection