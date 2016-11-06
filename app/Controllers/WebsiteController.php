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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug){

        $theme = new \App\Libs\Theme(Settings::get('theme'));

        $theme_engine = new \App\Libs\BladeThemeEngine($this->request);
        $theme_engine->setTheme($theme);

        //$theme_engine->runScript('before');
        
            if(is_array($slug)){
                $slug = $slug[0];
            }

            $requested_page = $slug=="/"? Page::find(Settings::get('home_page')) : Page::findBySlug($slug);

            if($requested_page){
                if(isset($requested_page->url) && file_exists($theme->getPath()."page_templates/".$requested_page->url.".blade.php")){
                    $template = "page_templates.".$requested_page->url;
                }else{
                    if(file_exists($theme->getPath().'page.blade.php')){
                        $template = 'page';
                    }else{
                        throw new \Exception('Can\'t find default page template!');
                    }
                }
            }else{
                 $theme_engine->render404();
            }



            if(Settings::get('website_down')==1){
                $theme_engine->renderWebsiteDown();
            }




            $theme_engine->pageTemplate($template);

 
           // $theme_engine->runScript('before_render');

       return $theme_engine->render([
                                    '_THEME_PATH' => $theme->getPath(),
                                    '_CURRENT_USER' => \Auth::user(),
                                    '_REQUESTED_PAGE' => $requested_page,
                                    ]);

    }


}
