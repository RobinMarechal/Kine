<section id="{{ $about->slug }}" data-id="{{ $about->id }}" class="about-block editable content-editable">
	<h3 class="about-title">
		{{ $about->title }}
		@if(isAdmin())
			{!! printButtonContent("", ['data-id' => $about->id, 'title' => 'Modifier la rubrique', 'data-namespace' => 'abouts'], 'update-data') !!}
			@if(isAdmin())
				<button data-toggle="tooltip"
						data-placement="top"
						title="Supprimer la rubrique"
						data-id="{{ $about->id }}"
						data-namespace="abouts"
						class="remove-data btn-remove btn btn-primary btn-edit trash create-new glyphicon glyphicon-trash">
				</button>
			@endif
		@endif
	</h3>
	<div class="about-content">
		{!! $about->content !!}
	</div>
</section>