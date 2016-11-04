<?php

namespace App\Controllers;

use App\Libs\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_key = '%'.$this->request->input('search').'%';

        $this->view->title(trans('search.title'));

        return $this->view->render('search/index', [
                                                    'search_for' => $this->request->input('search'),
                                                    'blogposts'  => \App\Model\Blogpost::where('title', 'LIKE', $search_key)->orWhere('summary', 'LIKE', $search_key)->orWhere('text', 'LIKE', $search_key)->get(),
                                                    'users'      => \App\User::where('username', 'LIKE', $search_key)->orWhere('name', 'LIKE', $search_key)->orWhere('email', 'LIKE', $search_key)->get(),
                                                    'pages'      => \App\Model\Page::where('name', 'LIKE', $search_key)->orWhere('page', 'LIKE', $search_key)->get(),
                                                    'files'      => [],
                                                  ]);
    }
}
