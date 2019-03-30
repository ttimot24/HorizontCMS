<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;


class SearchController extends Controller{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $search_key = "%".$this->request->input('search')."%";

        $search_engine = new \App\Libs\SearchEngine();
        $search_engine->registerModel(\App\Model\Blogpost::class);
        $search_engine->registerModel(\App\Model\User::class);
        $search_engine->registerModel(\App\Model\Page::class);

        $search_engine->executeSearch($search_key);

        $this->view->title(trans('search.title'));
        return $this->view->render("search/index",[
                                                    'search_for' => $this->request->input('search'),   
                                                    'search_engine' => $search_engine,
                                                    'files' => [],
                                                  ]);
    }


}
