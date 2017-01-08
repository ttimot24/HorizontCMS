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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug){

        $slug = explode("/",$slug);

        //\App::setLocale('hu');

        $theme = new \App\Libs\Theme(Settings::get('theme'));

        $theme_engine = new $this->engines[$theme->getConfig('theme_engine','hcms')]($this->request);
        $theme_engine->setTheme($theme);

        $theme_engine->runScript('before');
        
            if(is_array($slug)){
                $slug = $slug[0];
            }


            if(Settings::get('website_down')==1 && (\Auth::user()==null || !\Auth::user()->isAdmin())){
                $theme_engine->renderWebsiteDown();
            }


            $requested_page = $slug==""? Page::find(Settings::get('home_page')) : Page::findBySlug($slug);

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
                                    '_THEME_PATH' => $theme->getPath(),
                                    '_CURRENT_USER' => \Auth::user(),
                                    '_REQUESTED_PAGE' => $requested_page,
                                    ]);

    }



    public function authenticate(){

    }





}
