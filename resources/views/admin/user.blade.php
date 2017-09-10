@extends('layouts.admin')

@section('title')
	{{ $user->name }}
@endsection


@section('content')
	<h1> {{ $user->name }} </h1>
	<hr>

	<h4>Informations principales :</h4>

	<table data-table="users" class="table table-hover table-striped">
		<tbody>
			<tr data-id="{{ $user->id }}" data-namespace="users">
				<td width="150">Adresse email</td>
				<td data-pattern="email" data-field="email" class="user-edition-field-container" data-toggle="input" data-max-length="80"> {{ $user->email }} </td>
			</tr>
			<tr data-id="{{ $user->id }}" data-namespace="users">
				<td width="150">Téléphone</td>
				<td data-pattern="phone" data-field="phone" class="user-edition-field-container" data-toggle="input" data-max-length="12"> {{ $user->phone }} </td>
			</tr>
		</tbody>
	</table>

	<hr>
	<h4>Contacts : </h4>

	<table id="table-contacts" data-table="contacts" class="table table-hover table-striped" data-user-id="{{ $user->id }}">
		<thead>
			<td class="col-lg-3">Nom :</td>
			<td class="col-lg-4">Valeur :</td>
			<td class="col-lg-4">Description :</td>
			<td class="col-lg-1"></td>
		</thead>
		<tbody>
			@forelse($user->contacts as $c)
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