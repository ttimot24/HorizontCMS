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
    public function index(Request $request){


        $this->view->title(trans('theme.themes'));
        return $this->view->render("theme/index",[
                                                    'active_theme' => new \App\Libs\Theme($request->settings['theme']),
                                                    'all_themes' => collect(array_slice(scandir("themes"),2))->map(function ($theme) { return new \App\Libs\Theme($theme); })
                                                ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        return $this->{$id}();
    }

     /**
     * Display config page.
     *
     * @return \Illuminate\Http\Response
     */
    public function config($slug){

        $websiteController = new \App\Controllers\WebsiteController($this->request,new \App\Libs\ViewResolver());
        $websiteController->before();

        $theme_engine = new \App\Libs\ThemeEngine($this->request);
        $theme_engine->setTheme(new \App\Libs\Theme($this->request->settings['theme']));

        $theme_engine->boot();

		\Website::initalize($theme_engine);

        $this->view->title(trans('theme.config'));
        return $this->view->render("theme/config",[
                                                    'active_theme' => new \App\Libs\Theme($this->request->settings['theme']),
                                                    'website_content' => $websiteController->index($this->request->input('page')),
                                                ]);
    }


    public function options($theme){

        if(!Settings::has('custom_css_'.snake_case($theme))){
            $theme_css = new Settings();
            $theme_css->setting = 'custom_css_'.snake_case($theme);
            $theme_css->value = "";
            $theme_css->more = 1;
            $theme_css->save();
        }

        $theme = new \App\Libs\Theme($theme == null? $this->request->settings['theme'] : $theme);

        $translations = [];

        foreach($theme->getSupportedLanguages() as $lang){
            $translations[$lang] = json_decode(file_get_contents($theme->getPath()."lang/".$lang.".json"));
        }

        
        $this->view->title(trans('Theme options'));
        return $this->view->render('theme.options',['option' => empty($this->request->input('option'))? 'style' : $this->request->input('option') , 'translations' => $translations, 'theme' => $theme->root_dir,'settings'=> $this->request->settings]);
    }

    public function updateTranslations($theme){

        if($this->request->isMethod('POST')){

            try{
                $theme = new \App\Libs\Theme($theme == null? $this->request->settings['theme'] : $theme);

                $translations = [];

                foreach($theme->getSupportedLanguages() as $lang){
    
                    file_put_contents($theme->getPath()."lang/".$lang.".json",json_encode($this->request->input($lang,new \stdClass())));

                }

                return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_saved_settings')]);
            
            }catch(\Exception $e){
                \Log::error($e);
                return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
            }


        }

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
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        if ($request->hasFile('up_file')){

            $file_name = $request->up_file[0]->store('framework/temp');

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


    public function destroy($theme){

        if(\File::deleteDirectory("themes/".$theme)){
            return $this->redirectToSelf()->withMessage(['success' => trans('Succesfully deleted the theme!')]);
        }else{
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);         
        }

    }

    public function onlinestore(){

        $this->view->title(trans('Theme center'));

        $repo_status = true;

        try{

            $themes = json_decode(file_get_contents(\Config::get('horizontcms.sattelite_url').'/get_themes.php'));

            if($themes==null){
                throw ErrorException('Could not fetch Themes');
            }

        }catch(\ErrorException $e){
            $themes = [];
            $repo_status = false;
        }

        return $this->view->render('theme/store',[ 'online_themes' => $themes, 'repo_status' => $repo_status ]);


    }

}
