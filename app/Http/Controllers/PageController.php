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
                                                        'welcome_page' => Page::find(Settings::get('welcome_page')),
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


            if($page->save()){
                return $this->insideLink('page/edit/'.$page->id);
            }

            
        }


        
        $this->view->js('resources/assets/ckeditor/ckeditor.js');

        $this->view->title(trans('page.new_page'));
        return $this->view->render('pages/create',[
                                                    'all_page' => Page::all(),
                                                    //'page_templates' => array_slice(scandir('themes/'.Settings::get('theme')."/page_templates"),2);
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
