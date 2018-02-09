@extends('layouts.app')

@section('title')
    Qui Sommes-Nous
@endsection


@section('content')
    <article @editable($content)>
        <h1 class="content-title">
            {{ $content->title }}
        </h1>
        @if(isAdmin())
            {!! editButton($content, ['title' => 'Modifier']) !!}

        @endif

        <hr>

        <div class="content-box content-content">
            {!! $content->content !!}
        </div>

        <hr>
    </article>
@endsection