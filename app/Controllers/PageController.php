<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;

use App\Model\Page;

class PageController extends Controller{
 

    protected $itemPerPage = 25;
    protected $imagePath = 'images/pages';

    /**
     * Creates image directories if they not exists.
     *
     * @return \Illuminate\Http\Response
    */
    public function before(){
        if(!file_exists(storage_path($this->imagePath.'/thumbs'))){
            \File::makeDirectory(storage_path($this->imagePath.'/thumbs'), $mode = 0777, true, true);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug){


        $this->view->title(trans('page.pages'));
        return $this->view->render('pages/index',[
                                                        'number_of_pages' => Page::count(),
                                                        'all_pages' => Page::orderBy('queue')->paginate($this->itemPerPage),
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
            $page->queue = 99;
            $page->page = $this->request->input('page');
            $page->author_id = \Auth::user()->id;


            if ($this->request->hasFile('up_file')){
                 
                 $img = $this->request->up_file->store($this->imagePath);

                 $page->image = basename($img);

                 \Intervention\Image\ImageManagerStatic::make(storage_path($img))->fit(300, 200)->save(storage_path($this->imagePath.'/thumbs/'.$page->image));
                 
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
                                                        'page_templates' => (new \App\Libs\Theme($this->request->settings['theme']))->templates(),
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
            $page->page = $this->request->input('page');


            if ($this->request->hasFile('up_file')){
                 
                 $img = $this->request->up_file->store($this->imagePath);

                 $page->image = basename($img);

                 \Intervention\Image\ImageManagerStatic::make(storage_path($img))->fit(300, 200)->save(storage_path($this->imagePath.'/thumbs/'.$page->image));
                 
            }
            

            if($page->save()){
                return $this->redirect(admin_link("page-edit",$page->id))->withMessage(['success' => trans('message.successfully_updated_page')]);
            }else{
                return $this->redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
            }

            
        }

    }


    public function setHomePage($id){

        if(\App\Model\Settings::where("setting","home_page")->update(['value' => $id])){
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




    public function reorder(){

        try{
            
            $order = json_decode($this->request->input("order"),true);
            
            for($i=0; $i<count($order); $i++){
                $page = \App\Model\Page::find($order[$i]);
                $page->queue = $i;

                $page->save();
            }

        }catch(Exception $e){
            echo $e->getMessage();
        }


    }


}
