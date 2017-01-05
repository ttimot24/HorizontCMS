<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;


class ScreenLockController extends Controller{
 

    public function lockUp(){

        $user = \App\Model\User::find($this->request->input('id'));

        if (\Hash::check($this->request->input('password'), $user->password)) {
            return response()->json(TRUE);
        }

        return response()->json(FALSE);
    }


}
