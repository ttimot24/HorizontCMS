<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;

use App\Model\Blogpost;

class BlogpostController extends Controller{
  
    protected $itemPerPage = 25;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug){


        $this->view->title("Blogposts");
        return $this->view->render('blogposts/index',[
                                                        'number_of_blogposts' => Blogpost::count(),
                                                        'all_blogposts' => Blogpost::orderBy('id','desc')->paginate($this->itemPerPage),
                                                    ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){

        $this->view->title('View blogpost');
        return $this->view->render('blogposts/view',['blogpost' => Blogpost::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //
    }
}
