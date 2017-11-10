@extends('layouts.admin')

@section('title')
	{{ $doctor->name }}
@endsection


@section('content')
	<h1> {{ $doctor->name }} </h1>
	<hr>

	<h4>Informations principales :</h4>

	<table data-table="users" class="table table-hover table-striped">
		<tbody>
			{{--<tr data-id="{{ $doctor->id }}" data-namespace="users">--}}
			{{--<td width="150">Adresse email</td>--}}
			{{--<td data-pattern="email" data-field="email" class="user-edition-field-container" data-toggle="input" data-max-length="80"> {{ $doctor->email }} </td>--}}
			{{--</tr>--}}
			<tr data-id="{{ $doctor->id }}" data-namespace="doctors">
				<td width="150">Téléphone</td>
				<td data-pattern="phone" data-field="phone" class="user-edition-field-container" data-toggle="input" data-max-length="12"> {{ $doctor->phone }} </td>
			</tr>
			<tr data-id="{{ $doctor->id }}" data-namespace="doctors">
				<td width="150">Embauche à</td>
				<td data-field="starts_at" data-pattern="time" class="user-edition-field-container" data-toggle="input" data-input-type="time" data-max-length="12">
					{{ !isset($doctor->starts_at) ? '' : DateTime::createFromFormat("H:i:s", $doctor->starts_at)->format("H:i") }}
				</td>
			</tr>
			<tr data-id="{{ $doctor->id }}" data-namespace="doctors">
				<td width="150">Débauche à</td>
				<td data-field="ends_at" data-pattern="time" class="user-edition-field-container" data-toggle="input" data-input-type="time" data-max-length="12">
					{{ !isset($doctor->ends_at) ? '' :  DateTime::createFromFormat("H:i:s", $doctor->ends_at)->format("H:i") }}
				</td>
			</tr>
			<tr data-id="{{ $doctor->id }}" data-namespace="doctors">
				<td width="150">Résumé</td>
				<td data-field="resume" data-pattern="varchar" class="user-edition-field-container" data-toggle="input" data-max-length="255">
					{{ $doctor->resume }}
				</td>
			</tr>
			<tr data-id="{{ $doctor->id }}" data-namespace="doctors">
				<td width="150">Description</td>
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

	<table id="table-contacts" data-table="contacts" class="table table-hover table-striped" data-user-id="{{ $doctor->id }}">
		<thead>
			<td class="col-md-3">Nom :</td>
			<td class="col-md-4">Valeur :</td>
			<td class="col-md-4">Description :</td>
			<td class="col-md-1"></td>
		</thead>
		<tbody>
			@forelse($doctor->contacts as $c)
				<tr data-id="{{ $c->id }}" data-namespace="contacts">
					<td class="user-edition-field-container" data-field="name" data-toggle="input" data-max-length="255">{{ $c->name }}</td>
					<td data-pattern="link|address|phone|email" class="user-edition-field-container" data-field="value" data-toggle="input" data-max-length="255">{{ $c->value
					}}</td>
					<td class="user-edition-field-container" data-field="description" data-toggle="input" data-max-length="255">{{ $c->description }}</td>
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