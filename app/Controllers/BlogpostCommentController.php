<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;

use App\Model\BlogpostComment;

class BlogpostCommentController extends Controller{
 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

       

        if($this->request->isMethod('POST')){

            $blogpost_comment = new BlogpostComment();
            $blogpost_comment->blogpost_id = $this->request->input('blogpost_id');
            $blogpost_comment->comment = $this->request->input('comment');
            $blogpost_comment->user_id = \Auth::user()->id;

            if($blogpost_comment->save()){               
                return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_created_blogpost_comment')]);
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id){
      	 

            $blogpost_comment = BlogpostComment::find($id);

            $blogpost_comment = new BlogpostComment();
            $blogpost_comment->blogpost_id = $this->request->input('blogpost_id');
            $blogpost_comment->comment = $this->request->input('comment');
            $blogpost_comment->user_id = \Auth::user()->id;


            if($blogpost_comment->save()){               
                return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_updated_blogpost_comment')]);
            }else{
                return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
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
        

        if(BlogpostComment::find($id)->delete()){
			return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_deleted_blogpost_comment')]);
        }


        return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);

    }


}
