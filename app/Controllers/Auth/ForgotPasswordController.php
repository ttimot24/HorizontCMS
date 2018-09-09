<?php

namespace App\Controllers\Auth;

use App\Libs\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use \App\Libs\ViewResolver;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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

    public function showLinkRequestForm()
    {
        $this->view->title("Forgot password");
        return $this->view->render('auth/passwords/email');
    }

}
