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


Route::get('/me', function (Request $request) {
    $request->user()->image = $request->user()->getImage();
    return $request->user();
})->middleware(['auth.basic']);

Route::get('/blogposts',function(){

    $blogposts = \App\Model\Blogpost::getPublished();
   // $blogposts->load('author');
    $blogposts->load('category');

    return $blogposts;
});

Route::get('/pages',function(){

    $pages = \App\Model\Page::active();
   // $pages->load('author');
    $pages->load('parent');

    return $pages;
});


Route::post('lock-up',function(Request $request){

    $user = \App\Model\User::find($request->input('id'));
    
    if ($user->isActive() && \Hash::check($request->input('password'), $user->password)) {
        return response()->json(TRUE);
    }

    return response()->json(FALSE);

});


Route::get('get-page-slug/{title}',function($title){
	 return response()->json(str_slug($title));
});
