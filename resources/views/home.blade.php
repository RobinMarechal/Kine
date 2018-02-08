@extends('layouts.app')

@section('content')

    <div @editable($content)>
        @if(isAdmin())
            {!! editButton($content, ['title' => 'Modifier le contenu', 'data-placement' => 'left']) !!}
        @endif

        <h1 class="content-title">{{ $content->title }}</h1>
            <hr>
        <div class="content-content">
            {!! $content->content !!}
        </div>
    </div>

@stop