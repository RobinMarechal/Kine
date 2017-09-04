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

	<form class="row" action="{{url('inscription')}}" method="post">

		{{ csrf_field() }}

		<div class="col-lg-8 col-lg-offset-2 form-group {{ $errors->has('name') ? 'has-error' : ''}}">
			<input required type="text" name="name" class="form-control" placeholder="Votre prénom et nom" value="{{old('name')}}">
			@if($errors->has('name'))
				<ul class="input-error-block">
					@foreach($errors->get('name') as $error)
						<li class="input-error">{{$error}}</li>
					@endforeach
				</ul>
			@endif
		</div>

		<div class="col-lg-8 col-lg-offset-2 form-group {{ $errors->has('email') ? 'has-error' : ''}}">
			<input required type="email" name="email" class="form-control" placeholder="Votre adresse email" value="{{old('email')}}">
			@if($errors->has('email'))
				<ul class="input-error-block">
					@foreach($errors->get('email') as $error)
						<li class="input-error">{{$error}}</li>
					@endforeach
				</ul>
			@endif
		</div>

		<div class="col-lg-8 col-lg-offset-2 form-group {{ $errors->has('password') ? 'has-error' : ''}}">
			<input required type="password" name="password" class="form-control" placeholder="Votre mot de passe">
			@if($errors->has('password'))
				<ul class="input-error-block">
					@foreach($errors->get('password') as $error)
						<li class="input-error">{{$error}}</li>
					@endforeach
				</ul>
			@endif
		</div>

		<div class="col-lg-8 col-lg-offset-2 form-group {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
			<input required type="password" name="password_confirmation" class="form-control" placeholder="Confirmation de votre mot de passe">
			@if($errors->has('password_confirmation'))
				<ul class="input-error-block">
					@foreach($errors->get('password_confirmation') as $error)
						<li class="input-error">{{$error}}</li>
					@endforeach
				</ul>
			@endif
		</div>

		<div align="center" class="form-group col-lg-8 col-lg-offset-2">
			<button class="btn btn-primary col-lg-6 col-lg-offset-3">Inscription</button>
		</div>

	</form>

	<hr>

	<a href="{{ url('connexion') }}"><span class="glyphicon glyphicon glyphicon-arrow-right"></span> Cliquez ici si vous avez déjà un compte ou que vous souhaitez vous connecter
		avec Facebook</a>

@endsection