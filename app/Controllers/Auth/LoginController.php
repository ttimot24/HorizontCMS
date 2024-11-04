<?php

namespace App\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function redirectTo()
    {
        return route('dashboard.index');
    }

    /**
     *
     * Returns if email or username is for authentication.
     */

    public function username()
    {
        return 'username';
    }


    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {

        return view('auth.login', [
            'app_name' => \Config::get('app.name'),
            'admin_logo' => url(\Config::get('horizontcms.admin_logo')),
        ]);
    }



    public function logout(Request $request)
    {

        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate(true);

        return redirect(route('login'));
    }
}
