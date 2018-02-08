@extends('layouts.admin')

@section('title')
    {{ $state == \App\Bug::PENDING ? 'Bugs en attente' : $state == \App\Bug::SOLVED ? 'Bugs résolus' : 'Tous les bugs' }}
@endsection


@section('content')
    <h1>
        {{ $state == \App\Bug::PENDING ? 'Bugs en attente' : $state == \App\Bug::SOLVED ? 'Bugs résolus' : 'Tous les bugs' }}
    </h1>
    <hr>

    <table id="bug-list" class="bugs-list table table-hover table-striped">
        <thead>
        <tr>
            <td align="center" width="120">Signalé le</td>
            <td align="center" width="120">Résolu le</td>
            <td width="">Résumé</td>
            <td align="center" width="200">Signalé par</td>
            <td align="center" width="50"></td>
        </tr>
        </thead>
        <tbody>

        @forelse ($bugs as $bug)
            <tr data-id="{{ $bug->id }}" data-solved="{{ $bug->solved_at ? 'true' : 'false' }}"
                class="hover-container bug {{ $bug->solved_at ? 'bug-solved' : 'bug-pending' }}">
                <td align="center" class="bug-created_at">{{ $bug->created_at->format('d/m/Y') }}</td>
                <td align="center"
                    class="{{ $bug->solved_at ? 'olive' : 'red center' }} bug-solved_at">{{ $bug->solved_at ? $bug->solved_at->format('d/m/Y') : '-' }}</td>
                <td class="bug-summary"><a href="/admin/bugs/{{ $bug->id }}">{{ only($bug->summary, 120)}}</a></td>
                <td align="center" class="bug-user">{{ $bug->user ? $bug->user->name : '-' }}</td>
                <td align="center" class="bug-controls">
                    <a title="Marquer ce bug comme non-résolu" data-toggle="tooltip"
                       data-update="bugs-pending"
                       class="bug-controls--set-pending red btn-icon show-on-hover-container show-on-hover @if(!$bug->solved_at) hidden @endif"><i
                                class="far fa-minus-square fa-2x"></i></a>

                    <a title="Marquer ce bug comme résolu" data-toggle="tooltip"
                       data-update="bugs-solved"
                       class="bug-controls--set-solved olive btn-icon show-on-hover-container show-on-hover @if($bug->solved_at) hidden @endif"><i
                                class="far fa-check-square fa-2x"></i></a>
                </td>
            </tr>
        @empty
            <tr>
                <td align="center">-</td>
                <td align="center">-</td>
                <td>-</td>
                <td align="center">-</td>
                <td align="center"></td>
            </tr>
        @endforelse
        </tbody>

    </table>

    <div align="right">{!! $bugs->render() !!}</div>

    <hr>
    @if($state == \App\Bug::SOLVED)
        <a href="/admin/bugs"> <i class="fas fa-bug"></i> Voir les bugs non résolus</a> <br>
        <a href="/admin/bugs/tous"> <i class="fas fa-bug"></i> Voir tous les bugs</a>
    @elseif($state == \App\Bug::PENDING)
        <a href="/admin/bugs/resolus"> <i class="fas fa-bug"></i> Voir les bugs résolus</a><br>
        <a href="/admin/bugs/tous"> <i class="fas fa-bug"></i> Voir tous les bugs</a>
    @else
        <a href="/admin/bugs"> <i class="fas fa-bug"></i> Voir les bugs non résolus</a><br>
        <a href="/admin/bugs/resolus"> <i class="fas fa-bug"></i> Voir les bugs résolus</a>
    @endif


@endsection


@section('js')

@endsection