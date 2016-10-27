<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;

use App\Http\Requests;
use App\Model\Settings;
use App\Libs\ThemeEngine;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {


        $theme_engine = new \App\Libs\ThemeEngine($this->request);
        $theme_engine->addTheme(new \App\Libs\Theme(Settings::get('theme')));

        /*
            if(is_array($slug)){
                $slug = $slug[0];
            }

            $requested_page = Page::findBySlug($slug);

            if($requested_page){
                $template = $requested_page->url;
            }else{
                 $template = 404;
            }

            $theme_engine->pageTemplate($template);
        */


       return $theme_engine->render();
    }


}
