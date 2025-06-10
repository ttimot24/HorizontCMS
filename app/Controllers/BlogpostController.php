<?php

namespace App\Controllers;

use App\Controllers\Trait\UploadsImage;
use \Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Model\Blogpost;

class BlogpostController extends Controller
{

    use UploadsImage;

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
        $blogposts = Blogpost::orderBy('id', 'desc')->paginateSortAndFilter();

        if ($request->wantsJson()) {
            foreach($request->get('with', []) as $relation) {
                $blogposts->load($relation);
            }
            return response()->json($blogposts);
        }

        return view('blogposts.index', [
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

        return view('blogposts.form', [
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

        return $blogpost->save() ? redirect(route("blogpost.edit", ['blogpost' => $blogpost]))->withMessage(['success' => trans('message.successfully_created_blogpost')])
            : redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Blogpost $blogpost)
    {

        if ($request->wantsJson()) {
            foreach($request->get('with', []) as $relation) {
                $blogpost->load($relation);
            }
            return response()->json($blogpost);
        }


        return view('blogposts.view', [
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

        return view('blogposts.form', [
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
            return redirect()->back()->with('blogpost', $blogpost)->withMessage(['success' => trans('message.successfully_updated_blogpost')]);
        } else {
            return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
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
            return redirect(route("blogpost.index"))->withMessage(['success' => trans('message.successfully_deleted_blogpost')]);
        }


        return redirect(route("blogpost.index"))->withMessage(['danger' => trans('message.something_went_wrong')]);
    }
}
