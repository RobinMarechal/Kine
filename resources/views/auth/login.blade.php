@extends('layouts.app')

@section('content')

	<h1>Connexion</h1>
	<hr>

	{{--<form class="fb-login-button-container" method="get" action="{{ $loginUrl }}">--}}
	<form class="fb-login-button-container" method="get" action="{{url('/connexion/facebook')}}">

		{{ csrf_field() }}
		<button class="fb-login-button">
			<table>
				<tr>
					<td with="30"><img width="30" src="{{url('img/fb-logo-login.png')}}"></td>
					<td width="290" align="center">Se connecter avec Facebook</td>
				</tr>
			</table>
		</button>
	</form>
	{{--</form>--}}

	<hr width="50%">

	<form class="row" action="{{url('connexion')}}" method="post">

		{{ csrf_field() }}

		<div class="col-md-8 col-md-offset-2 form-group">
			<input type="email" name="email" class="form-control" placeholder="Votre adresse email">
		</div>

		<div class="col-md-8 col-md-offset-2 form-group">
			<input type="password" name="password" class="form-control" placeholder="Votre mot de passe">
		</div>

		<div class="col-md-8 col-md-offset-2 checkbox">
			<label for="remember"><input type="checkbox" name="remember" id="remember"> Se souvenir de moi </label>
		</div>

		<br>

		<div align="center" class="checkbox col-md-8 col-md-offset-2">
			<button class="btn btn-primary col-md-6 col-md-offset-3">Connexion</button>
		</div>

	</form>

	<hr>

	<a href="{{ url('inscription') }}"><span class="glyphicon glyphicon glyphicon-arrow-right"></span> Cliquez ici pour vous inscrire sans utiliser Facebook</a>

@endsection