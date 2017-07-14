@extends('layouts.app')

@section('content')

	<h1>Inscription</h1>
	<hr>

	{{--<form class="fb-login-button-container" method="get" action="{{url('/login/facebook')}}">--}}

	{{--{{ csrf_field() }}--}}
	{{--<button class="fb-login-button">--}}
	{{--<table>--}}
	{{--<tr>--}}
	{{--<td with="30"><img width="30" src="{{url('img/fb-logo-login.png')}}"></td>--}}
	{{--<td width="290" align="center">Se connecter avec Facebook</td>--}}
	{{--</tr>--}}
	{{--</table>--}}
	{{--</button>--}}
	{{--</form>--}}

	{{--<hr width="50%">--}}

	<form class="row" action="{{url('register')}}" method="post">

		{{ csrf_field() }}

		<div class="col-lg-8 col-lg-offset-2 form-group">
			<input type="text" name="name" class="form-control" placeholder="Votre prénom et nom" value="{{old('name')}}">
		</div>

		<div class="col-lg-8 col-lg-offset-2 form-group">
			<input type="email" name="email" class="form-control" placeholder="Votre adresse email" value="{{old('email')}}">
		</div>

		<div class="col-lg-8 col-lg-offset-2 form-group">
			<input type="password" name="password" class="form-control" placeholder="Votre mot de passe">
		</div>

		<div class="col-lg-8 col-lg-offset-2 form-group">
			<input type="password" name="password_confirmation" class="form-control" placeholder="Confirmation de votre mot de passe">
		</div>

		<div align="center" class="form-group col-lg-8 col-lg-offset-2">
			<button class="btn btn-primary col-lg-6 col-lg-offset-3">Inscription</button>
		</div>

	</form>

	<hr>

	<a href="{{ url('login') }}"><span class="glyphicon glyphicon glyphicon-arrow-right"></span> Cliquez ici si vous avez déjà un compte ou que vous souhaitez vous connecter
		avec Facebook</a>

@endsection