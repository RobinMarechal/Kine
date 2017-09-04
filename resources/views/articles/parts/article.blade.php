<div class="article-item">
	<h3><a href="{{url('articles/'.$article->id)}}">{{$article->title}}</a></h3>

	<p class="written-by">Publiée par {{ $article->user->name }}, le {{ $article->created_at->format('d/m/Y') }}</p>
	<p class="written-by">Vu {{number_format($article->views, 0, '.', ' ')}} fois</p>

	<div class="tags-block">
		@forelse($article->tags as $tag)
			<a href="{{url('articles/tag/'.$tag->name)}}" class="tag" title="Cliquez pour voir tous les articles possédant ce tag">{{$tag->name}}</a>
		@empty
		@endforelse
	</div>
</div>