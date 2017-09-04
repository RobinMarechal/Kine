<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\User;
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
     *
     * @var string
     */
    protected $redirectTo = '/';


	/**
	 * Create a new controller instance.
	 *
	 * @param Request $request
	 */
    public function __construct(Request $request)
    {
		parent::__construct($request);
		$this->middleware('guest')->except('logout');
    }

	public function redirectToProvider()
	{
		return Socialite::driver('facebook')->redirect();
	}

	public function callback (Request $request)
	{
		$social = Socialite::driver('facebook')->user();

		$user = User::whereFacebookId($social->id)->first();

		// This facebook user already exists in DB
		if($user)
		{
			Auth::login($user, true);
			Flash::success("Vous êtes maintenant connecté !");
			return redirect('/');
		}

		$user = User::whereEmail($social->email)->first();

		// This user exists but not using facebook
		if($user)
		{
			Auth::login($user, true);
			$user->facebook_id = $social->id;
			$user->save();
			Flash::success("Vous êtes maintenant connecté !");
			return redirect('/');
		}

		// We create the user

		$arr = [
			'email' => $social->email,
			'facebook_id' => $social->id,
			'name' 	=> $social->name,
		];

		$user = User::create($arr);

		// ... And we log it in
		if($user)
		{
			Auth::login($user, true);
			Flash::success("Vous êtes maintenant connecté !");
			return redirect('/');
		}

		// an error happened
		Flash::error('Une erreur est survenue, impossible de vous connecter.');
		return Redirect::back();
    }

    public function login (Request $request)
	{
		$validator = $this->validator($request->all());
		if($validator->fails())
		{
			return Redirect::back()->withErrors($validator->errors())->withInput();
		}

		$user = Auth::attempt($request->only(['email', 'password']), $request->has('remember'));

		if($user)
		{
			return \redirect('/');
		}

		Flash::error('Une erreur est survenue, impossible de vous connecter.');
		return Redirect::back();
	}


	private function validator ($data)
	{
		return Validator::make($data, [
			'email' => 'required|email',
			'password' => 'required'
		]);
	}
}
