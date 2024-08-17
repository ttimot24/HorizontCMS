<?php

namespace App\Controllers;

use App\Controllers\Trait\UploadsImage;
use \Illuminate\Http\Request;
use App\Libs\Controller;
use App\Model\Blogpost;

class BlogpostController extends Controller
{

    use UploadsImage;

    protected $itemPerPage = 25;

    //TODO Use model path
    protected $imagePath = 'images/blogposts';

    /**
     * Creates image directories if they not exists.
     *
     */
    public function before()
    {
        //TODO Use model path
		\File::ensureDirectoryExists($this->imagePath . '/thumbs');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blogposts = Blogpost::orderBy('id', 'desc')->paginate($this->itemPerPage);

        if($request->wantsJson()){
            return response()->json($blogposts);
        }


        $this->view->title(trans('blogpost.blogposts'));
        return $this->view->render('blogposts/index', [
            'number_of_blogposts' => Blogpost::count(),
            'all_blogposts' =>  $blogposts,
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
        $request->validate(Blogpost::$rules);

        $blogpost = new Blogpost($request->all());
        $blogpost->slug = str_slug($request->input('title'), "-");
        $blogpost->author()->associate($request->user());
        $blogpost->comments_enabled = 1;

        $this->uploadImage($blogpost);

        return $blogpost->save() ? $this->redirect(route("blogpost.edit", ['blogpost' => $blogpost]))->withMessage(['success' => trans('message.successfully_created_blogpost')])
            : $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Blogpost $blogpost)
    {
    
        if($request->wantsJson()){
            return response()->json($blogpost);
        }

        $this->view->title(trans('blogpost.view_blogpost'));
        return $this->view->render('blogposts/view', [
            'blogpost' => $blogpost,
            'previous_blogpost' => Blogpost::where('id', '<', $blogpost->id)->max('id'),
            'next_blogpost' =>  Blogpost::where('id', '>', $blogpost->id)->min('id'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Blogpost $blogpost)
    {

        $this->view->title(trans('blogpost.edit_blogpost'));

        return $this->view->render('blogposts/form', [
            'blogpost' => $blogpost,
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
    public function update(Request $request, Blogpost $blogpost)
    {

	    $blogpost->fill($request->all());

        $blogpost->slug = str_slug($request->input('title', $blogpost->title), "-");
        $blogpost->category_id = $request->input('category_id', $blogpost->category_id);
        
        $blogpost->author()->associate($request->user());

        $this->uploadImage($blogpost);

        if ($blogpost->save()) {
            return $this->redirectToSelf()->with('blogpost', $blogpost)->withMessage(['success' => trans('message.successfully_updated_blogpost')]);
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

}
