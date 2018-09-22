<?php

namespace App\Controllers\Auth;


use App\Libs\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use \App\Libs\ViewResolver;

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
    public function __construct(ViewResolver $viewResolver)
    {
        $this->view = $viewResolver;
        $this->middleware('guest');
    }


    public function showResetForm(Request $request, $token = null)
    {
        $this->view->title("Password reset");
        return $this->view->render('auth/passwords/reset',['token' => $token, 'email' => $request->email]);
    }

}
