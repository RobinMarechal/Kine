@extends('layouts.admin')

@section('title')
    Bug
@endsection


@section('content')

    <div @editable($bug)>
        @if(!$bug->solved_at)
            <button id="set-bug-solved" data-namespace="bugs" data-id="5" class="btn btn-edit btn-primary btn-validate">
                <i aria-hidden="true" class="fa fa-check"></i>
            </button>
        @endif
        <h1>Bug signalé</h1>
        <hr>
        <p>Signalé le {{ $bug->created_at->format('d/m/Y \à H:i') }}@if($bug->user)
                par <b>{{ $bug->user->name }}</b> @endif.</p>

        <div class="bug-solved_at">
            @if($bug->solved_at) Résolu le {{ $bug->solved_at->format('d/m/Y \à H:i') }} @endif
        </div>

        <h3>Résumé : </h3>
        <p class="bug-summary">{{ $bug->summary }}</p>

        <div class="bug-description">
            @if($bug->description)
                <h3>Description : </h3>
                {!! $bug->description !!}
            @endif
        </div>
    </div>

    <hr>

    <a href="/admin/bugs/"><i class="fas fa-bug"></i>Revenir à la liste des bugs</a>

@endsection


@section('js')

@endsection