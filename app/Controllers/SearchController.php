<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Services\SearchEngine;

class SearchController extends Controller
{

    public function __construct(private SearchEngine $search_engine) {

    }

    public function index(Request $request)
    {

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
        if(auth()->check() && auth()->user()->hasPermission('user')){
            $this->search_engine->registerModel(\App\Model\User::class);
        }
        $this->search_engine->registerModel(\App\Model\Page::class);

        $this->search_engine->executeSearch($search_key);

        if($request->wantsJson()){
            return response()->json($this->search_engine->getAllResults());
        }

        return view("search.index", [
            'search_for' => $request->input('search'),
            'search_engine' => $this->search_engine,
            'files' => [],
        ]);
    }
}
