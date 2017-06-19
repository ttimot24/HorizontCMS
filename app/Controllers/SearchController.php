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

        $this->view->title(trans('search.title'));
        return $this->view->render("search/index",[
                                                    'search_for' => $this->request->input('search'),   
                                                    'blogposts' => \App\Model\Blogpost::search($search_key),
                                                    'users' => \App\Model\User::search($search_key),
                                                    'pages' => \App\Model\Page::search($search_key),
                                                    'files' => [],
                                                  ]);
    }


}
