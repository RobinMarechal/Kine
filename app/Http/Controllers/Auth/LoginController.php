<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Login;
use App\User;
use function env;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Helpers\FacebookHelper;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 * @var string
	 */
	protected $redirectTo = '/';


	/**
	 * Create a new controller instance.
	 *
	 * @param Request $request
	 */
	public function __construct (Request $request)
	{
		parent::__construct($request);
		$this->middleware('guest')
			 ->except('logout');
	}


	/**
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function redirectToProvider ()
	{
		return Socialite::driver('facebook')
						->scopes(['email', 'manage_pages'])
						->redirect();

		//		$fb = FacebookHelper::getFacebookInstance();
		//
		//		$helper = $fb->getRedirectLoginHelper();
		//		$loginUrl = $helper->getLoginUrl('http://kine.dev/login/facebook/callback', ['email', 'manage_pages']);
		//
		//		dd($loginUrl);
		//
		//		dd($helper->getAccessToken());
		//		$permissions = ['email', 'manage_pages'];
		//		$loginUrl = $helper->getLoginUrl('http://kine.dev/login/facebook/callback', $permissions);
		//
		//		return redirect($loginUrl, 301);
	}


	public function callback (Request $request)
	{
		$social = Socialite::driver('facebook')
						   ->user();

		//		$fb = FacebookHelper::getFacebookInstance();
		//
		//		$helper = $fb->getRedirectLoginHelper();
		//
		//		try{
		//			$accessToken = $helper->getAccessToken();
		//		}catch(FacebookResponseException $e)
		//		{
		//			dd($e->getMessage());
		//		}
		//
		//		dd(1, $accessToken);

		$user = User::whereFacebookId($social->id)
					->first();

		// This facebook user already exists in DB
		if ($user) {
			Auth::login($user, true);
			$user->connections++;
			$user->save();

			Login::create([
				'user_id'    => $user->id,
				'ip_address' => $request->server('REMOTE_ADDR'),
			]);

			Flash::success("Vous êtes maintenant connecté !");

			return redirect('/');
		}

		$user = User::whereEmail($social->email)
					->first();

		// This user exists but not using facebook
		if ($user) {
			Auth::login($user, true);

			$user->facebook_id = $social->id;
			$user->connections++;
			$user->save();

			Login::create([
				'user_id'    => $user->id,
				'ip_address' => $request->server('REMOTE_ADDR'),
			]);

			Flash::success("Vous êtes maintenant connecté !");

			return redirect('/');
		}

		// We create the user

		$arr = [
			'email'       => $social->email,
			'facebook_id' => $social->id,
			'name'        => $social->name,
		];

		$user = User::create($arr);

		// ... And we log it in
		if ($user) {
			Auth::login($user, true);

			Login::create([
				'user_id'    => $user->id,
				'ip_address' => $request->server('REMOTE_ADDR'),
			]);

			Flash::success("Vous êtes maintenant connecté !");

			return redirect('/');
		}

		// an error occurred
		Flash::error('Une erreur est survenue, impossible de vous connecter.');

		return Redirect::back();
	}


	public function login (Request $request)
	{
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			Flash::error("Les champs n'ont pas été renseignés correctements.");

			return Redirect::back()
						   ->withErrors($validator->errors())
						   ->withInput();
		}

		$test = Auth::attempt($request->only(['email', 'password']), $request->has('remember'));

		if ($test) {
			$user = Auth::user();
			$user->connections++;
			$user->save();

			Login::create([
				'user_id'    => $user->id,
				'ip_address' => $request->server('REMOTE_ADDR'),
			]);

			Flash::success('Vous êtes maintenant connecté !');

			return \redirect('/');
		}

		Flash::error('Une erreur est survenue, impossible de vous connecter.');

		return Redirect::back();
	}


	private function validator ($data)
	{
		return Validator::make($data, [
			'email'    => 'required|email',
			'password' => 'required',
		]);
	}


	public function showLoginForm ()
	{
		$fb = FacebookHelper::getFacebookInstance();

		$helper = $fb->getRedirectLoginHelper();
		$loginUrl = $helper->getLoginUrl('http://kine.dev/login/facebook/callback', ['email', 'manage_pages']);

		$loginUrl .= "&app_id=" . env('FACEBOOK_CLIENT_ID');

		return view('auth.login', compact('loginUrl'));
	}
}
