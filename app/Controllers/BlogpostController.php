<?php

namespace App\Controllers;

use \Illuminate\Http\Request;
use App\Libs\Controller;
use App\Model\Blogpost;

class BlogpostController extends Controller
{


    protected $itemPerPage = 25;
    protected $imagePath = 'images/blogposts';

    /**
     * Creates image directories if they not exists.
     *
     */
    public function before()
    {
        if (!file_exists(storage_path($this->imagePath . '/thumbs'))) {
            \File::makeDirectory(storage_path($this->imagePath . '/thumbs'), $mode = 0777, true, true);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->view->title(trans('blogpost.blogposts'));
        return $this->view->render('blogposts/index', [
            'number_of_blogposts' => Blogpost::count(),
            'all_blogposts' => Blogpost::orderBy('id', 'desc')->paginate($this->itemPerPage),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->view->title(trans('blogpost.new_blogpost'));
        return $this->view->render('blogposts/form', [
            'categories' => \App\Model\BlogpostCategory::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $blogpost = new Blogpost($request->all());
        $blogpost->slug = str_slug($request->input('title'), "-");
        $blogpost->author_id = $request->user()->id;
        $blogpost->comments_enabled = 1;

        if ($request->hasFile('up_file')) {

            $img = $request->up_file->store($this->imagePath);
            $blogpost->image = basename($img);
            if (extension_loaded('gd')) {
                \Intervention\Image\ImageManagerStatic::make(storage_path($img))->fit(300, 200)->save(storage_path($this->imagePath . '/thumbs/' . $blogpost->image));
            }
        }

        return $blogpost->save() ? $this->redirect(route("blogpost.edit", ['blogpost' => $blogpost]))->withMessage(['success' => trans('message.successfully_created_blogpost')])
            : $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {

        $this->view->title(trans('blogpost.view_blogpost'));
        return $this->view->render('blogposts/view', [
            'blogpost' => Blogpost::find($id),
            'previous_blogpost' => Blogpost::where('id', '<', $id)->max('id'),
            'next_blogpost' =>  Blogpost::where('id', '>', $id)->min('id'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {

        $this->view->title(trans('blogpost.edit_blogpost'));

        return $this->view->render('blogposts/form', [
            'blogpost' => Blogpost::find($id),
            'categories' => \App\Model\BlogpostCategory::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {

        $blogpost = Blogpost::find($id);

        $blogpost->title = $request->input('title');
        $blogpost->slug = str_slug($request->input('title'), "-");
        $blogpost->category_id = $request->input('category_id');
        $blogpost->summary = $request->input('summary');
        $blogpost->text = clean($request->input('text'));
        $blogpost->author_id = $request->user()->id;
        if ($request->has("active")) {
            $blogpost->active = $request->input("active");
        }

        if ($request->hasFile('up_file')) {

            $img = $request->up_file->store($this->imagePath);

            $blogpost->image = basename($img);

            if (extension_loaded('gd')) {
                \Intervention\Image\ImageManagerStatic::make(storage_path($img))->fit(300, 200)->save(storage_path($this->imagePath . '/thumbs/' . $blogpost->image));
            }
        }


        if ($blogpost->save()) {
            return $this->redirect(route("blogpost.edit", ['blogpost' => $blogpost]))->withMessage(['success' => trans('message.successfully_updated_blogpost')]);
        } else {
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }

    /**
     * Remove the specified resource from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blogpost $blogpost)
    {

        if ($blogpost->delete()) {
            return $this->redirect(route("blogpost.index"))->withMessage(['success' => trans('message.successfully_deleted_blogpost')]);
        }


        return $this->redirect(route("blogpost.index"))->withMessage(['danger' => trans('message.something_went_wrong')]);
    }

    public function feature($id)
    {
        $blogpost = Blogpost::find($id);
        $blogpost->active = 2;

        if ($blogpost->save()) {
            return $this->redirectToSelf()->withMessage(['success' => trans('Action completed!')]);
        } else {
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }

    public function revokeFeature($id)
    {
        $blogpost = Blogpost::find($id);
        $blogpost->active = 1;

        if ($blogpost->save()) {
            return $this->redirectToSelf()->withMessage(['success' => trans('Action completed!')]);
        } else {
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }

    public function enableComment($id)
    {
        $blogpost = Blogpost::find($id);
        $blogpost->comments_enabled = 1;

        if ($blogpost->save()) {
            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_enabled_blogpost')]);
        } else {
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }


    public function disableComment($id)
    {
        $blogpost = Blogpost::find($id);
        $blogpost->comments_enabled = 0;

        if ($blogpost->save()) {
            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_disabled_blogpost')]);
        } else {
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }
}
