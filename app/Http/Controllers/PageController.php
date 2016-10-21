<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;

use App\Model\Page;
use App\Model\Settings;

class PageController extends Controller{
 

    protected $itemPerPage = 25;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug){


        $this->view->title(trans('page.pages'));
        return $this->view->render('pages/index',[
                                                        'number_of_pages' => Page::count(),
                                                        'all_pages' => Page::paginate($this->itemPerPage),
                                                        'visible_pages' => Page::where('visibility',1)->count(), 
                                                        'home_page' => Page::find(Settings::get('home_page')),
                                                    ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


       

        if($this->request->isMethod('POST')){

            $page = new Page();
            $page->name = $this->request->input('name');
            $page->url = $this->request->input('url');
            $page->visibility = $this->request->input('visibility');
            $page->parent_id = $this->request->input('parent_id');
            $page->queue = $this->request->input('queue');
            $page->page = $this->request->input('page');
            $page->author_id = \Auth::user()->id;


            if ($this->request->hasFile('up_file')){
                 
                 $page->image = str_replace('images/pages/','',$this->request->up_file->store('images/pages'));

            }

            if($page->save()){
                return $this->insideLink('page/edit/'.$page->id);
            }

            
        }


        
        $this->view->js('resources/assets/ckeditor/ckeditor.js');

        $this->view->title(trans('page.new_page'));
        return $this->view->render('pages/create',[
                                                    'all_page' => Page::all(),
                                                    'page_templates' => (new App\Libs\Theme(Settings::get('theme')))->templates();
                                                    ]);
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

        $this->view->title(trans('page.view_page'));
        return $this->view->render('pages/view',['blogpost' => Page::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){


        $this->view->js('resources/assets/ckeditor/ckeditor.js');

        $this->view->title(trans('page.edit_page'));

        return $this->view->render('pages/edit',[
                                                        'page' => Page::find($id),
                                                        'all_page' => Page::all(),
                                                        'page_templates' => (new App\Libs\Theme(Settings::get('theme')))->templates();
                                                    ]);
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


    /**
     * Remove the specified resource from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        

        Page::find($id)->delete();

        return $this->redirectToSelf();
    }


}
