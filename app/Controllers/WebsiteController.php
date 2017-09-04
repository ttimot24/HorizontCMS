<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;

use App\Http\Requests;
use App\Model\Settings;
use App\Libs\ThemeEngine;
use App\Model\Page;

class WebsiteController extends Controller
{

    private $engines = [
                'hcms' => \App\Libs\ThemeEngine::class,
                'blade' => \App\Libs\BladeThemeEngine::class,
                //'twig' => \App\Libs\TwigThemeEngine::class,
                ];

    public $theme;


    public function before(){
        $this->theme = new \App\Libs\Theme($this->request->settings['theme']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page){
        

        //\App::setLocale('hu');


        $theme_engine = new $this->engines[$this->theme->getConfig('theme_engine','hcms')]($this->request);
        $theme_engine->setTheme($this->theme);

        $theme_engine->runScript('before');
        


            if($this->request->settings['website_down']==1 && (\Auth::user()==null || !\Auth::user()->isAdmin())){
                $theme_engine->renderWebsiteDown();
            }


            $requested_page = $page==""? Page::find($this->request->settings['home_page']) : Page::findBySlug($page);

            if($requested_page!=NULL){
                if(isset($requested_page->url) && $requested_page->url!="" && $theme_engine->templateExists($requested_page->url)){
                    $template = "page_templates.".$requested_page->url;
                }else{

                   // if($theme_engine->defaultTemplateExists('page')){
                        $template = 'page';
                    /*}else{
                        throw new \Exception('Can\'t find default page template!');
                    }*/
                }
            }else{
                 $theme_engine->render404();
            }


            $theme_engine->pageTemplate($template);


            $theme_engine->runScript('before_render');

       return $theme_engine->render([
                                    '_THEME_PATH' => $this->theme->getPath(),
                                    '_REQUESTED_PAGE' => $requested_page,
                                    ]);

    }



    public function authenticate(){


		if (\Auth::attempt(['username' => $this->request->input('username'), 'password' => $this->request->input('password')])) {

            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_logged_in')]);
        }

        return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
    }



    public function logout(){

        \Auth::logout();

        return redirect()->back();
    }



}
