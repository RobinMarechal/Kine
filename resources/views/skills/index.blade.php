@extends('layouts.app')

@section('title')
	Nos Compétences -
@endsection


@section('content')
	{{--<h1>Qui Sommes-Nous ?</h1>--}}
	{{--<hr>--}}

	<data id="title-template"
		  data-container-id="section-titles"
		  data-tag="button"
		  data-classes="skills-section-btn skill-titles">
	</data>

	<data id="content-template"
		  data-container-id="section-contents"
		  data-tag="div"
		  data-classes="skill-section">
	</data>

	<div class="row content-editable editable">
		{!! printButtonContent("skill", ['id' => 'edit-skill']) !!}
		@if(isAdmin())
			<button id="btn-remove-skill" title="Supprimer la rubrique" class="btn btn-primary btn-remove btn-edit trash create-new glyphicon glyphicon-trash"></button>
		@endif
		<div id="section-titles" class="col-lg-3">
			@forelse($skills as $s)
				<span
						data-skill-id="{{ $s->id }}"
						data-skill-index="{{ $s->index }}"
						class="skills-section-btn skill-titles @if($s->id == $skills[0]->id) selected @endif">
					{{ $s->title }}
				</span>
			@empty
			@endforelse

			@if(isAdmin())
				<a id="create-skills-content" title="Ajouter une rubrique" href="#{{--{{ url('nos-competences/ajouter') }}--}}"
				   class="create-new glyphicon glyphicon-plus btn-hover"></a>
			@endif
		</div>


		<div id="section-contents" class="col-lg-9">
			@forelse($skills as $s)
				<div data-skill-id="{{ $s->id }}" class="skill-section @if($s->id == $skills[0]->id) selected @endif">
					<h1>{{ $s->title }}</h1>
					<hr>

					<p>
						{!! $s->content !!}
					</p>
				</div>
			@empty

			@endforelse
		</div>
	</div>

@endsection