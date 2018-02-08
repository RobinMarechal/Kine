@extends('layouts.admin')

@section('title')
    Liste des Utilisateurs
@endsection


@section('content')
    <h1>Liste des utilisateurs inscrits</h1>
    <hr>

    <table id="doctors-list" class="doctors-list users-list table table-hover table-striped">
        <thead>
        <tr>
            <td>Docteur</td>
            <td align="center">Cours encadrés</td>
            <td align="center">News publiées</td>
            <td align="center">Articles publiés</td>
            <td width="100" align="center"></td>
        </tr>
        </thead>
        <tbody>
        @forelse($doctors as $d)
            <tr class="doctor user hover-container" data-id="{{ $d->id }}">
                <td>
                    <a title="Voir la fiche détaillée de cet utilisateur"
                       href="{{ url('admin/utilisateurs/'.$d->id) }}">{{ $d->name }}</a>
                    {{--{{ $d->name }}--}}
                </td>
                <td align="center" class="supervised-courses user-info">
                    {{ $d->courses->count() }}
                </td>
                <td align="center" class="published-news user-info">
                    {{ $d->news->count() }}
                </td>
                <td align="center" class="published-articles user-info">
                    {{ $d->articles->count() }}
                </td>
                <td class="controls" align="center">
                    <span class="pointer downgrade-user btn-table-control show-on-hover-container show-on-hover">
                        <i title="Supprimer cet utilisateur de la liste des docteurs"
                           class="fas fa-sm fa-angle-double-down downgrade-doctor" aria-hidden="true"></i>
                    </span>
                    <span class="pointer edit-user btn-table-control show-on-hover-container show-on-hover">
                        <i title="Voir la fiche de cet utilisateur" class="fas fa-sm fa-user-md edit-user"></i>
                    </span>
                </td>
            </tr>
        @empty
        @endforelse
        </tbody>
    </table>

    <hr>

    <table id="users-list" class="users-list table table-hover table-striped">
        <thead>
        <tr>
            <td>Utilisateur</td>
            <td width="150" align="center">Cours suivis</td>
            <td>Tags</td>
            <td width="100" align="center"></td>
        </tr>
        </thead>
        <tbody>
        @forelse($users as $u)
            <tr class="user hover-container" data-id="{{ $u->id }}">
                <td>
                    {{--<a title="Voir la fiche détaillée de cet utilisateur" href="{{ url('admin/utilisateurs/'.$u->id) }}">{{ $u->name }}</a>--}}
                    {{ $u->name }}
                </td>
                <td align="center" class="user-courses user-info">
                    {{ $u->courses->count() }}
                </td>
                <td class="user-tags-list user-info">
                    <div class="table-tag-list">
                        @forelse($u->tags as $tag)
                            <span class="tag">{{$tag->name}}</span>
                        @empty
                            -
                        @endforelse
                    </div>
                </td>
                <td align="center" class="controls">
                    <span class="pointer upgrade-user btn-table-contro show-on-hover-container show-on-hover ">
                        <i title="Ajouter cet utilisateur à la liste des docteurs"
                           class="fas fa-sm fa-angle-double-up upgrade-user" aria-hidden="true"></i>
                    </span>
                    <span class="pointer edit-user btn-table-control show-on-hover-container show-on-hover ">
                        <i title="Voir la fiche de cet utilisateur" class="fas fa-sm fa-edit edit-user"></i>
                    </span>
                </td>
            </tr>
        @empty
        @endforelse
        </tbody>
    </table>

@endsection


@section('js')

@endsection