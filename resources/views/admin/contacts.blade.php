@extends('layouts.admin')

@section('title')
    Contacts
@endsection


@section('content')
    <h1>Autres contacts</h1>
    <hr>


    <table id="table-contacts" data-table="contacts" class="table table-hover table-striped table-condensed">
        <thead>
        <td>Description :</td>
        <td>Valeur :</td>
        <td>Texte:</td>
        <td width="50"></td>
        </thead>
        <tbody>
        @forelse($contacts as $c)
            <tr data-id="{{ $c->id }}" data-namespace="contacts" class="hover-container">
                <td>
                    <input data-field="name"
                           data-pattern="varchar"
                           data-previous-value="{{ $c->name }}"
                           class="form-control input-sm input-bottom-border edit-data-field"
                           maxlength="255"
                           value="{{ $c->name }}">
                </td>
                <td>
                    <input data-field="value"
                           data-pattern="phone|email|link|address"
                           data-previous-value="{{ $c->value }}"
                           class="form-control input-sm input-bottom-border edit-data-field"
                           maxlength="255"
                           value="{{ $c->value }}">
                </td>
                <td>
                    <input data-field="display"
                           data-pattern="varchar"
                           data-previous-value="{{ $c->display }}"
                           class="form-control input-sm input-bottom-border edit-data-field"
                           maxlength="255"
                           value="{{ $c->display }}">
                </td>
                <td class="controls" align="center">
                    <span class="delete-contact pointer show-on-hover-container show-on-hover"
                          title="Supprimer cette ligne" data-toggle="tooltip">
                        <i class="fas fa-times-circle fa-sm" aria-hidden="true"></i>
                    </span>
                </td>
            </tr>
        @empty
        @endforelse
        </tbody>
        <tfoot>
        <tr>
            <td><input class="form-control input-sm" type="text" maxlength="80" name="name" id="new-contact-name"
                       placeholder="Ex: Cliquez ici pour appeler le téléphone princal"></td>
            <td><input class="form-control input-sm" type="text" maxlength="255" name="value" id="new-contact-value"
                       placeholder="Ex : 0645982631"></td>
            <td><input class="form-control input-sm" type="text" maxlength="255" name="description"
                       placeholder="Ex : Téléphone principal"
                       id="new-contact-description"></td>
            <td>
                <button title="Ajouter la ligne" class="btn btn-primary btn-sm add-contact" id="add-contact"><i
                            class="fa fa-plus"></i></button>
            </td>
        </tr>
        </tfoot>
    </table>

@endsection


@section('js')

@endsection