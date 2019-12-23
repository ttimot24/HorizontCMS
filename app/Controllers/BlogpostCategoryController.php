<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;

use App\Model\BlogpostCategory;

class BlogpostCategoryController extends Controller{
 

    protected $itemPerPage = 25;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug){



        $this->view->title(trans('category.category'));
        return $this->view->render('blogposts/category/index',[
                                                        'all_category' => BlogpostCategory::all(),
                                                    ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

       

        if($this->request->isMethod('POST')){

            $blogpost_category = new BlogpostCategory();
            $blogpost_category->name = $this->request->input('name');
            $blogpost_category->author_id = \Auth::user()->id;

            if ($this->request->hasFile('up_file')){
                 
                 $blogpost_category->image = str_replace('images/blogpostscategories/','',$this->request->up_file->store('images/blogpostscategories'));

            }

            if($blogpost_category->save()){
                return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_created_blogpost_category')]);
            }else{
            	return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
            }

            
        }

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
        $this->view->title(trans('category.category'));
        return $this->view->render('blogposts.category.view',['category' => \App\Model\BlogpostCategory::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){


        $this->view->title(trans('blogpost.edit_blogpost'));

        return $this->view->render('blogposts/category/edit',[
                                                        'category' => \App\Model\BlogpostCategory::find($id),
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

            $blogpost_category = BlogpostCategory::find($id);
            $blogpost_category->name = $this->request->input('name');

            if ($this->request->hasFile('up_file')){
                 
                 $blogpost_category->image = str_replace('images/blogpostscategories/','',$this->request->up_file->store('images/blogpostscategories'));

            }

            if($blogpost_category->save()){
                return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_updated_blogpost_category')]);
            }else{
                return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
            }

            
        }



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
        

        if(BlogpostCategory::find($id)->delete()){
			return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_deleted_blogpost_category')]);
        }


        return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);

    }


}
