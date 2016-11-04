<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;

use App\Model\Settings;

class ThemeController extends Controller{
 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug){


        $this->view->title(trans('theme.themes'));
        return $this->view->render("theme/index",[
                                                    'active_theme' => new \App\Libs\Theme(Settings::get("theme")),
                                                    'all_themes' => collect(array_slice(scandir("themes"),2))->map(function ($theme) { return new \App\Libs\Theme($theme); })
                                                ]);
    }


     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function set($theme){
        $setting = Settings::where('setting','theme')->first();
        $setting->value = $theme;
       
        if($setting->save()){
            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_changed_theme')]);
        }else{
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //
    }


    /**
     * Remove the specified resource from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){

    }


}
