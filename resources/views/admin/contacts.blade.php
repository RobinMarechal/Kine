@extends('layouts.admin')

@section('title')
	Contacts
@endsection


@section('content')
	<h1>Autres contacts</h1>
	<hr>


	<table id="table-contacts" data-table="contacts" class="table table-hover table-striped">
		<thead>
			<td class="col-md-3">Nom :</td>
			<td class="col-md-3">Valeur :</td>
			<td class="col-md-3">Texte :</td>
			<td class="col-md-1"></td>
		</thead>
		<tbody>
			@forelse($contacts as $c)
				<tr data-id="{{ $c->id }}" data-namespace="contacts">
					<td class="user-edition-field-container" data-field="name" data-toggle="input" data-max-length="255">{{ $c->name }}</td>
					<td data-pattern="link|address|phone|email" class="user-edition-field-container" data-field="value" data-toggle="input" data-max-length="255">{{ $c->value
					}}</td>
					<td class="user-edition-field-container" data-field="display" data-toggle="input" data-max-length="255">{{ $c->display }}</td>
					<td class="controls" align="center">
						<i title="Supprimer cette ligne" class="fa fa-times-circle delete-contact" aria-hidden="true"></i>
					</td>
				</tr>
			@empty
			@endforelse
		</tbody>
		<tfoot>
			<tr>
				<td><input class="form-control input-sm" type="text" maxlength="80" name="name" id="new-contact-name" placeholder="Ex : Téléphone principal"></td>
				<td><input class="form-control input-sm" type="text" maxlength="255" name="value" id="new-contact-value" placeholder="Ex : 0645982631"></td>
				<td><input class="form-control input-sm" type="text" maxlength="255" name="description" id="new-contact-description"></td>
				<td>
					<button title="Ajouter la ligne" class="btn btn-primary btn-sm add-contact" id="add-contact"><i class="fa fa-plus"></i></button>
				</td>
			</tr>
		</tfoot>
	</table>

@endsection


@section('js')

@endsection