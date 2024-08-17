<?php

namespace App\Controllers\Auth;


use App\Libs\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use \App\Libs\ViewResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request,ViewResolver $viewResolver)
    {
        $this->view = $viewResolver;
        $this->middleware('guest');

    }


    public function showResetForm(Request $request, $token = null)
    {
        $this->view->title("Password reset");
        return $this->view->render('auth/passwords/reset',['token' => $token, 'email' => $request->email,
                                                            'app_name' => \Config::get('app.name'),
                                                            'admin_logo' => url(\Config::get('horizontcms.admin_logo')),
                                                          ]);
    }


    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {

        $user->password = $password;
        $user->save();

        /*$user->forceFill([
            'password' => \Hash::make($password),
            'remember_token' => Str::random(60),
        ])->save();*/

        $this->guard()->login($user);
    }

}
