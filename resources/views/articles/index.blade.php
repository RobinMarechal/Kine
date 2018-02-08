@extends('layouts.app')

@section('title')
    Articles
@endsection


@section('content')

    <h1>Articles publiés
        @if(isAdmin())
            <a title="" data-placement="left" href="/articles/rediger" data-namespace="articles"
               class="create-new create-about title-btn-hover" data-toggle="tooltip"
               data-original-title="Créer une news"><i aria-hidden="true"
                                                       class="glyphicon glyphicon-plus"></i></a>
        @endif
    </h1>
    <hr>

    @forelse($articles as $article)
        @include('articles.parts.article', $article)
    @empty
        <p>Aucun article n'a été publié pour le moment</p>
    @endforelse

    <div align="right">{!! $articles->render() !!}</div>

    <hr>
    <div class="section-footer">
        <a href="{{ url('a-propos#tags') }}"><span class="fas fa-tags"></span> En savoir
            plur sur le système de tags.</a>
    </div>


@endsection


@section('js')

@endsection