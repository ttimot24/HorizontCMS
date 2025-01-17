<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Services\SearchEngine;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SearchEngine $search_engine)
    {
        $search_key = "%" . $request->input('search') . "%";

        $search_engine->registerModel(\App\Model\Blogpost::class);
        $search_engine->registerModel(\App\Model\User::class);
        $search_engine->registerModel(\App\Model\Page::class);

        $search_engine->executeSearch($search_key);

        return view("search.index", [
            'search_for' => $request->input('search'),
            'search_engine' => $search_engine,
            'files' => [],
        ]);
    }
}
