<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;

use App\Model\Page;

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
                                                        'home_page' => Page::find($this->request->settings['home_page']),
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
            $page->slug = str_slug($this->request->input('name'), "-");
            $page->url = $this->request->input('url');
            $page->visibility = $this->request->input('visibility');
            $page->parent_id = $this->request->input('parent_select')==0? NULL : $this->request->input('parent_id');
            $page->queue = 1;/*$this->request->input('queue');*/
            $page->page = $this->request->input('page');
            $page->author_id = \Auth::user()->id;


            if ($this->request->hasFile('up_file')){
                 
                 $page->image = str_replace('images/pages/','',$this->request->up_file->store('images/pages'));

            }

            if($page->save()){
                return $this->redirect(admin_link("page-edit",$page->id))->withMessage(['success' => trans('message.successfully_created_page')]);
            }else{
                return $this->redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
            }

            
        }


        
        $this->view->js('resources/assets/ckeditor/ckeditor.js');
        $this->view->js('app/View/pages/pages.script.js');
        $this->view->js('resources/js/controls.js');

        $this->view->title(trans('page.new_page'));
        return $this->view->render('pages/create',[
                                                    'all_page' => Page::all(),
                                                    'page_templates' => (new \App\Libs\Theme($this->request->settings['theme']))->templates(),
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
        $this->view->js('app/View/pages/pages.script.js');
        $this->view->js('resources/js/controls.js');

        $this->view->title(trans('page.edit_page'));

        return $this->view->render('pages/edit',[
                                                        'page' => Page::find($id),
                                                        'all_page' => Page::all(),
                                                        'page_templates' => (new \App\Libs\Theme(Settings::get('theme')))->templates(),
                                                    ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id){
        
        if($this->request->isMethod('POST')){

            $page = Page::find($id);
            $page->name = $this->request->input('name');
            $page->slug = str_slug($this->request->input('name'), "-");
            $page->url = $this->request->input('url');
            $page->visibility = $this->request->input('visibility');
            $page->parent_id = $this->request->input('parent_select')==0? NULL : $this->request->input('parent_id');
            $page->queue = 1;/*$this->request->input('queue');*/
            $page->page = $this->request->input('page');


            if ($this->request->hasFile('up_file')){
                 
                 $page->image = str_replace('images/pages/','',$this->request->up_file->store('images/pages'));

            }

            if($page->save()){
                return $this->redirect(admin_link("page-edit",$page->id))->withMessage(['success' => trans('message.successfully_updated_page')]);
            }else{
                return $this->redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
            }

            
        }

    }


    public function setHomePage($id){

        $home_page = \App\Model\Settings::where("setting","home_page")->get()->first();

        $home_page->value = $id;

        if($home_page->save()){
            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_set_homepage')]);
        }
        else{
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }    
    }


    /**
     * Remove the specified resource from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        
        if(Page::find($id)->delete()){
            return $this->redirect(admin_link("page-index"))->withMessage(['success' => trans('message.successfully_deleted_page')]);
        }


        return $this->redirect(admin_link("page-index"))->withMessage(['danger' => trans('message.something_went_wrong')]);
    }


}
