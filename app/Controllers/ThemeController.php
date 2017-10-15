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
       
        if(Settings::where('setting','theme')->update(['value' => $theme])){
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
    public function upload(){

        if ($this->request->hasFile('up_file')){

            $file_name = $this->request->up_file[0]->store('framework/temp');

        }

        $zip = new \ZipArchive;
        if ($zip->open("storage/".$file_name) === TRUE) {
            $zip->extractTo('themes/');
            $zip->close();
            
            \Storage::delete("storage/".$file_name);

            return $this->redirectToSelf()->withMessage(['success' => trans('Succesfully uploaded the theme!')]);
        } else {
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }


    public function delete($theme){

        if(\File::deleteDirectory("themes/".$theme)){
            return $this->redirectToSelf()->withMessage(['success' => trans('Succesfully deleted the theme!')]);
        }else{
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);         
        }

    }


}
