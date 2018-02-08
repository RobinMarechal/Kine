<section id="{{ $about->slug }}" data-id="{{ $about->id }}" class="about-block editable content-editable">
    <h3 class="about-title">
        {{ $about->title }}
        @if(isAdmin())
            {!! editButton($about, ['title' => 'Modifier la rubrique']) !!}
            {!! removeButton($about, ['title' => 'Supprimer la rubrique']) !!}
        @endif
    </h3>
    <div class="about-content">
        {!! $about->content !!}
    </div>
</section>