<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;

use App\Model\BlogpostComment;

class BlogpostCommentController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $blogpost_comment = new BlogpostComment($request->all());
        $blogpost_comment->blogpost_id = $request->input('blogpost_id');
        $blogpost_comment->author_id = \Auth::user()->id;

        return $this->redirectToSelf()->withMessage(
            $blogpost_comment->save() ? ['success' => trans('message.successfully_created_blogpost_comment')]
                : ['danger' => trans('message.something_went_wrong')]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogpostComment $blogpost_comment)
    {

        $blogpost_comment->blogpost_id = $this->request->input('blogpost_id');
        $blogpost_comment->comment = $this->request->input('comment');
        $blogpost_comment->author_id = \Auth::user()->id;


        return $this->redirectToSelf()->withMessage(
            $blogpost_comment->save() ? ['success' => trans('message.successfully_updated_blogpost_comment')]
                : ['danger' => trans('message.something_went_wrong')]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogpostComment $blogpostcomment)
    {


        return $this->redirectToSelf()->withMessage(
            $blogpostcomment->delete() ? ['success' => trans('message.successfully_deleted_blogpost_comment')]
                : ['danger' => trans('message.something_went_wrong')]
        );
    }
}
