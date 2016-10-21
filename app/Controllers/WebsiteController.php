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

        $theme_engine = new \App\Libs\BladeThemeEngine();
        $theme_engine->addTheme(new \App\Libs\Theme(Settings::get('theme')));


       return $theme_engine->render();
    }


}
