@extends('layouts.app')

@section('title')
    Conditions Générales d'Utilisation
@endsection


@section('content')

    <div @editable($cgu)>
        @if(Auth::check() && Auth::user()->email == 'robin-marechal@hotmail.fr')
            {!! editButton($cgu, ['title' => 'Modifier les CGU']) !!}
        @endif

        <h1 class="content-title">{{ $cgu->title }}</h1>
        <hr>
        <div class="content-content">
            {!! $cgu->content !!}
        </div>
    </div>

@endsection


@section('js')

@endsection