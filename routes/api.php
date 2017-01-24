<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');*/



Route::post('lock-up',function(Request $request){

	$user = \App\Model\User::find($request->input('id'));

    if (\Hash::check($request->input('password'), $user->password)) {
        return response()->json(TRUE);
    }

    return response()->json(FALSE);

});


Route::get('get-page-slug/{title}',function($title){
	 return response()->json(str_slug($title));
});
