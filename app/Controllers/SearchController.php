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
    public function index($search_key){
        $search_key = "%".$search_key."%";

        $this->view->title(trans('search.title'));
        return $this->view->render("search/index",[
                                                    'blogposts' => Blogpost::where(['title' => $search_key])->orWhere(['summary' => $search_key])->orWhere(['text' => $search_key]),
                                                    'users' => User::where(['username' => $search_key])->orWhere(['name' => $search_key])->orWhere(['email' => $search_key]),
                                                    'pages' => Page::where(['name' => $search_key])->orWhere(['page' => $search_key]),
                                                    'files' => [],
                                                  ]);
    }


}
