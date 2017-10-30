@extends('layouts.no-aside')

@section('title')
	Accueil
@endsection

@section('content')

	<div class="jumbotron bg-transparent shadow-bottom">
		<h1 class="text-md-center">Le Cabinet</h1>
		<div class="row">
			<div class="col-md-4">
				<img src="{{ url('img/logo.jpg') }}" class="img-fluid" alt="Logo du cabinet" title="Logo du cabinet">
			</div>
			<div class="col-md-8 text-justify">
				<br>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias architecto consectetur, consequuntur deleniti dolores eaque esse eum impedit magni nostrum odit praesentium repellat sequi ut veniam! Debitis distinctio impedit maiores?</p>
			</div>
		</div>
	</div>

	<div class="jumbotron bg-light">

		<h1 class="text-md-center">Qui Sommes-Nous ?</h1>
		<br><br>

		<div class="row">
			<div class="col-md-4 kine-qsn">
				<img src="{{ url('img/kines/test.png') }}" class="img-thumbnail card-img-top kine-qsn-img" alt="Pierre Gabory">
				<h2>Pierre Gabory</h2>
				<span class="text-justify">
					<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet
						risus. Etiam porta sem malesuada magna mollis euismod.
					<p>
				</span>
				<a href="#">En savoir plus <i class="fa fa-long-arrow-right"></i></a></p>
			</div>
			<div class="col-md-4 kine-qsn">
				<img src="{{ url('img/kines/test.png') }}" class="img-thumbnail card-img-top kine-qsn-img" alt="Pierre Gabory">
				<h2>Heading</h2>
				<span class="text-justify">
					<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet
						risus. Etiam porta sem malesuada magna mollis euismod.
					<p>
				</span>
				<a href="#">En savoir plus <i class="fa fa-long-arrow-right"></i></a></p>
			</div>
			<div class="col-md-4 kine-qsn">
				<img src="{{ url('img/kines/test.png') }}" class="img-thumbnail card-img-top kine-qsn-img" alt="Pierre Gabory">
				<h2>Heading</h2>
				<span class="text-justify">
					<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet
						risus. Etiam porta sem malesuada magna mollis euismod.
					<p>
				</span>
				<a href="#">En savoir plus <i class="fa fa-long-arrow-right"></i></a></p>
			</div>
		</div>
	</div>

@endsection


@section('js')

@endsection