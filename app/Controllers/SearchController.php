<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;
use App\Libs\SearchEngine;
use \App\Libs\ViewResolver;


class SearchController extends Controller
{

    private $search_engine;

    public function __construct(Request $request, ViewResolver $viewResolver, SearchEngine $search_engine)
    {
        parent::__construct($request, $viewResolver);

        $this->search_engine = $search_engine;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $search_key = "%" . $request->input('search') . "%";

        $this->search_engine->registerModel(\App\Model\Blogpost::class);
        $this->search_engine->registerModel(\App\Model\User::class);
        $this->search_engine->registerModel(\App\Model\Page::class);

        $this->search_engine->executeSearch($search_key);

        $this->view->title(trans('search.title'));

        return $this->view->render("search/index", [
            'search_for' => $request->input('search'),
            'search_engine' => $this->search_engine,
            'files' => [],
        ]);
    }
}
