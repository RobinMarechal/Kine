<?php

$title = 'Rédiger un article';
$buttonTitle = "Publier";

$articleTitle = "";
$articleContent = "";
$articleTagsInInput = "";

if (isset($article)) {
	$title = 'Modifier un article';
	$buttonTitle = "Modifier";

	$articleTitle = $article->title;
	$articleContent = $article->content;
	$articleTagsInInput = join(';', array_column($article->tags->toArray(), 'name'));
}

?>

@extends('layouts.app')

@section('title')
	{{ $title }}
@endsection


@section('content')
	<h1>{{ $title }}</h1>
	<hr>

	<form id="article-creation-form"
		  method="POST">

		{{ csrf_field() }}

		<div class="row">
			<div class="col-md-8">
				<div>
					<div class="form-group">
						<label class="label-control">Titre :</label>
						<input class="form-control"
							   id="bb_title"
							   name="title"
							   required
							   value="{{ $articleTitle }}">
					</div>

					<div class="form-group">
						<label class="label-control">Texte :</label>
						<textarea data-toggle="editor"
								  class="form-control"
								  name="content"
								  id="content"> {{$articleContent}} </textarea>
					</div>

				</div>

			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Tags :</label>

					<div id="tag-list">
					</div>

					<br>

					<input type="text" name="tags" id="tags-input" hidden value="{{$articleTagsInInput}}">

					<ul class="list-group"
						id="tag-list-group">
						<li class="list-group-item input">
							<div class="input-group">
								<input id="add-tag-input"
									   type="text"
									   class="form-control"
									   placeholder="Chercher ou créer un tag">
								<span class="input-group-btn">
								<button id="add-tag-button"
										class="btn btn-primary"
										type="button">Sélectionner</button>
							</span>
							</div>
						</li>
						<div class="items">
							@forelse($tags as $t)
								<li class="list-group-item tag-item">{{ $t->name }}</li>
							@empty

							@endforelse
						</div>
					</ul>
				</div>
			</div>
		</div>

		<br>

		<div class="row" align="right">
			<button type="reset" class="btn btn-default">Réinitialiser </button>
			<button id="article-creation-preview" class="btn btn-primary" type="button"> Prévisualiser </button>
			<button type="button" id="submit-article-creation" class="btn btn-primary">Publier </button>
		</div>
	</form>

@endsection


@section('js')

@endsection