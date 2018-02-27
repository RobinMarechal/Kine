@extends('layouts.admin')

@section('title')
    {{ $doctor->name }}
@endsection


@section('content')
    <h1> {{ $doctor->name }} </h1>
    <hr>

    <h4>Informations principales :</h4>

    <table data-id="{{ $doctor->id }}" data-namespace="doctors" data-table="users"
           class="table table-hover table-striped table-condensed">
        <tbody>
        <tr>
            <td width="150" class="td-padding-top">Téléphone</td>
            <td>
                <input data-field="phone"
                       data-pattern="phone"
                       data-previous-value="{{ $doctor->phone }}"
                       class="form-control input-sm input-bottom-border edit-data-field"
                       maxlength="12"
                       value="{{ $doctor->phone }}">
            </td>
        </tr>
        <tr>
            <td width="150" class="td-padding-top">Embauche à</td>
            <td>
                <input data-pattern="time"
                       data-field="starts_at"
                       data-previous-value="{{ !isset($doctor->starts_at) ? '' : DateTime::createFromFormat("H:i:s", $doctor->starts_at)->format("H:i") }}"
                       class="form-control input-sm input-bottom-border edit-data-field"
                       maxlength="12"
                       value="{{ !isset($doctor->starts_at) ? '' : DateTime::createFromFormat("H:i:s", $doctor->starts_at)->format("H:i") }}">
            </td>
        </tr>
        <tr>
            <td width="150" class="td-padding-top">Débauche à</td>
            <td>
                <input data-pattern="time"
                       data-field="ends_at"
                       data-previous-value="{{ !isset($doctor->ends_at) ? '' :  DateTime::createFromFormat("H:i:s", $doctor->ends_at)->format("H:i") }}"
                       class="form-control input-sm input-bottom-border edit-data-field"
                       maxlength="12"
                       value="{{ !isset($doctor->ends_at) ? '' :  DateTime::createFromFormat("H:i:s", $doctor->ends_at)->format("H:i") }}">
            </td>
        </tr>
        <tr>
            <td width="150" class="td-padding-top">Résumé</td>
            <td>
                <input data-field="resume"
                       data-pattern="varchar"
                       data-previous-value="{{ $doctor->resume }}"
                       class="form-control input-sm input-bottom-border edit-data-field"
                       maxlength="255"
                       value="{{ $doctor->resume }}">
            </td>
        </tr>
        <tr>
            <td width="150" class="td-padding-top">Description</td>
            <td data-pattern="text">
						<textarea data-toggle="focus-sensitive-editor"
                                  data-namespace="doctors"
                                  data-id="{{ $doctor->id }}"
                                  class="form-control"
                                  name="description"
                                  id="description">
							{{ $doctor->description }}
						</textarea>
            </td>
        </tr>
        </tbody>
    </table>

    <hr>
    <h4>Contacts : </h4>

    <table id="table-contacts" data-table="contacts" class="table table-hover table-striped table-condensed"
           data-user-id="{{ $doctor->id }}">
        <thead>
        <td>Description :</td>
        <td>Valeur :</td>
        <td>Texte:</td>
        <td width="50"></td>
        </thead>
        <tbody>
        @forelse($doctor->contacts as $c)
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
                       placeholder="Cliquez ici pour appeler le téléphone princal"></td>
            <td><input class="form-control input-sm" type="text" maxlength="255" name="value" id="new-contact-value"
                       placeholder="Ex : 0645982631"></td>
            <td><input class="form-control input-sm" type="text" maxlength="255" name="display"
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