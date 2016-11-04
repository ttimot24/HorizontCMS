<?php

namespace App\Controllers;

use App\Libs\Controller;
use App\Model\Blogpost;
use Illuminate\Http\Request;

class BlogpostCategoryController extends Controller
{
    protected $itemPerPage = 25;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $this->view->title(trans('blogpost.blogposts'));

        return $this->view->render('blogposts/category/index', [
                                                        'number_of_blogposts' => Blogpost::count(),
                                                        'all_blogposts'       => Blogpost::orderBy('id', 'desc')->paginate($this->itemPerPage),
                                                    ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($this->request->isMethod('POST')) {
            $blogpost = new Blogpost();
            $blogpost->title = $this->request->input('title');
            $blogpost->category_id = $this->request->input('category_id');
            $blogpost->summary = $this->request->input('summary');
            $blogpost->text = $this->request->input('text');
            $blogpost->author_id = \Auth::user()->id;

            if ($this->request->hasFile('up_file')) {
                $blogpost->image = str_replace('images/blogposts/', '', $this->request->up_file->store('images/blogposts'));
            }

            if ($blogpost->save()) {
                return $this->redirect('admin/blogpost/edit/'.$blogpost->id)->withMessage(['success' => trans('message.successfully_created_blogpost')]);
            } else {
                return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
            }
        }



        $this->view->js('resources/assets/ckeditor/ckeditor.js');

        $this->view->title(trans('blogpost.new_blogpost'));

        return $this->view->render('blogposts/create', [
                                                        'categories' => \App\Model\BlogpostCategory::all(),
                                                        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->view->title(trans('blogpost.view_blogpost'));

        return $this->view->render('blogposts/view', [
                                                        'blogpost'          => Blogpost::find($id),
                                                        'previous_blogpost' => Blogpost::where('id', '<', $id)->max('id'),
                                                        'next_blogpost'     => Blogpost::where('id', '>', $id)->min('id'),
                                                    ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->view->js('resources/assets/ckeditor/ckeditor.js');

        $this->view->title(trans('blogpost.edit_blogpost'));

        return $this->view->render('blogposts/edit', [
                                                        'blogpost'   => Blogpost::find($id),
                                                        'categories' => \App\Model\BlogpostCategory::all(),
                                                    ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $blogpost = Blogpost::find($id);

        $blogpost->title = $this->request->input('title');
        $blogpost->category_id = $this->request->input('category_id');
        $blogpost->summary = $this->request->input('summary');
        $blogpost->text = $this->request->input('text');
        $blogpost->author_id = \Auth::user()->id;

        if ($this->request->hasFile('up_file')) {
            $blogpost->image = str_replace('images/blogposts/', '', $this->request->up_file->store('images/blogposts'));
        }

        if ($blogpost->save()) {
            return $this->redirect('admin/blogpost/edit/'.$blogpost->id)->withMessage(['success' => trans('message.successfully_updated_blogpost')]);
        } else {
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from database.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if (BlogpostCategory::find($id)->delete()) {
            return $this->redirect('admin/blogpostcategory')->withMessage(['success' => trans('message.successfully_deleted_blogpostcategory')]);
        }


        return $this->redirect('admin/blogpostcategory')->withMessage(['danger' => trans('message.something_went_wrong')]);
    }
}
