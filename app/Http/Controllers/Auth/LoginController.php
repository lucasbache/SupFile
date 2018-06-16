<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\User;


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

    public function socialLogin($social)

    {

        return Socialite::driver($social)->redirect();

    }
    public function handleProviderCallback($social)

    {

        $userSocial = Socialite::driver($social)->user();

        $user = User::where(['email' => $userSocial->getEmail()])->first();

        if($user){

            Auth::login($user);
            $id = 'h';
            return redirect()->action('repoController@index', compact('id'));

        }else{

            return view('auth.register',['name' => $userSocial->getName(), 'email' => $userSocial->getEmail()]);

        }

    }

    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
