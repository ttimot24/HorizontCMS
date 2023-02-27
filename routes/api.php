<?php

use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

Route::post('/auth', function (Request $request) {
   
    if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){ 

        $user = Auth::user(); 

        if($user->isActive()){
            
            $user->api_token = Str::random(60);

            $user->save();

            return response()->json(['user' => $user], 200);
        }
    } 

    return response()->json(['error'=>'Username or password incorrect'], 401);
});

Route::get('/me', function (Request $request) {
    $request->user()->image = $request->user()->getImage();
    return $request->user();
})->middleware(['auth.basic']);


Route::get('/blogposts',function(Request $request){

    $blogposts = \App\Model\Blogpost::getPublished()->forPage($request->input('page'),$request->input('num'));
   // $blogposts->load('author');
    $blogposts->load('category');

    return $blogposts;
});

Route::get('/pages',function(Request $request){

    $pages = \App\Model\Page::active()->forPage($request->input('page'),$request->input('num'));
   // $pages->load('author');
    $pages->load('parent');

    return $pages;
});

Route::get('/categories',function(Request $request){

    $categories = \App\Model\BlogpostCategory::all()->forPage($request->input('page'),$request->input('num'));

    return $categories;
});

Route::get('/plugins',function(Request $request){

    if(\Auth::user()->hasPermission("plugins")){
        return response()->json(['message' => 'Permission denied!'], 403);
    }

    $plugins = \App\Model\Plugin::all()->forPage($request->input('page'),$request->input('num'));

    return $plugins;

})->middleware('auth:api');

Route::post('lock-up',function(Request $request){

    $user = \App\Model\User::find($request->input('id'));
    
    if (isset($user) && $user->isActive() && \Hash::check($request->input('password'), $user->password)) {
        return response()->json(TRUE);
    }

    return response()->json(FALSE);

});


Route::get('get-page-slug/{title}',function($title){
	 return response()->json(str_slug($title));
});
