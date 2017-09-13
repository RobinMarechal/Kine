<?php

namespace App\Http\Controllers\Auth;

use App\Login;
use App\User;
use App\Http\Controllers\Controller;
use function array_merge;
use function bcrypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Laracasts\Flash\Flash;
use function redirect;

class RegisterController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 * @var string
	 */
	protected $redirectTo = '/';


	/**
	 * Create a new controller instance.
	 *
	 * @param \App\Http\Requests\Request $request
	 */
	public function __construct (\App\Http\Requests\Request $request)
	{
		parent::__construct($request);
		$this->middleware('guest');
	}


	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array $data
	 *
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator (array $data)
	{
		return Validator::make($data, [
			'name'     => 'required|string|max:255',
			'email'    => 'required|string|email|max:255',
			'password' => 'required|string|min:6|confirmed',
		]);
	}


	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array $data
	 *
	 * @return \App\User
	 */
	protected function create (array $data)
	{
		return User::create([
			'name'     => $data['name'],
			'email'    => $data['email'],
			'password' => bcrypt($data['password']),
		]);
	}


	protected function registered (Request $request, $user)
	{
		Flash::success("Vous êtes maintenant inscrit ! ");
	}


	protected function register (Request $request)
	{
		$validator = $this->validator($request->all());
		$test = User::where('email', $request->email)
					->first();

		if ($validator->fails()) {
			Flash::error("L'inscription a échoué, les champs renseignés sont incorrects.");

			return Redirect::back()
						   ->withInput($request->only(['name', 'email']))
						   ->withErrors($validator->errors());
		}

		if (isset($test) && !isset($test->facebook_id)) {
			Flash::error("L'inscription a échoué, L'adresse email renseignée est déjà utilisée.");

			return Redirect::back()
						   ->withInput($request->only(['name', 'email']))
						   ->withErrors($validator->errors());
		}


		if (isset($test)) {
			// user already registered
			if (isset($test->facebook_id)) {
				// But with facebook
				$test->password = Hash::make($request->password);
				$test->save();
				unset($test->password);

				Auth::login($test);

				Login::create([
					'user_id' => $test->id,
					'ip_address' => $request->server('REMOTE_ADDR')
				]);

				Flash::success('Inscription réussie, votre compte à été synchronisé avec votre compte Facebook.');

				return redirect('/');
			}
			else {
				// Without facebook
				Flash::error('Cet utilisateur existe déja');

				return Request::back()
							  ->withInput($request->only(['name', 'email']));
			}
		}
		else if ($user = User::create(['email' => $request->email, 'name' => $request->name, 'password' => bcrypt($request->password)])) {
			Auth::login($user);
			Login::create([
				'user_id' => $user->id,
				'ip_address' => $request->server('REMOTE_ADDR')
			]);

			Flash::success('Vous êtes maintenant incrit !');

			return redirect('/');
		}
		else {
			Flash::error('Inscription impossible, une erreur est survenue. Si le problème persiste, veuillez contacter un administrateur.');

			return Redirect::back();
		}
	}
}
