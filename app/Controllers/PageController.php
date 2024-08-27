<?php

namespace App\Controllers;

use App\Controllers\Trait\UploadsImage;
use Illuminate\Http\Request;
use App\Libs\Controller;
use App\Model\Page;

class PageController extends Controller
{

    use UploadsImage;

    protected $itemPerPage = 25;
    protected $imagePath = 'images/pages';

    /**
     * Creates image directories if they not exists.
     *
     * @return \Illuminate\Http\Response
     */
    public function before()
    {
        \File::ensureDirectoryExists($this->imagePath . '/thumbs');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pages = Page::orderBy('queue')->paginate($this->itemPerPage);

        if($request->wantsJson()){
            return response()->json($pages);
        }

        $this->view->js('resources/js/dragndrop.js');

        $this->view->title(trans('page.pages'));
        return $this->view->render('pages/index', [
            'all_pages' => $pages,
            'visible_pages' => Page::where('visibility', 1)->count(),
            'home_page' => Page::find($this->request->settings['home_page']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $request->validate(Page::$rules);

        $this->view->js('resources/js/pages.js');

        $this->view->title(trans('page.new_page'));
        return $this->view->render('pages/form', [
            'all_page' => Page::all(),
            'page_templates' => (new \App\Libs\Theme($request->settings['theme']))->templates(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $page = new Page($request->all());
        $page->slug = str_slug($request->input('name'), "-");
        $page->parent_id = $request->input('parent_select') == 0 ? null : $request->input('parent_id');
        $page->queue = 99;
        $page->page = clean($request->input('page'));
        $page->author()->associate($request->user());

        $this->uploadImage($page);

        if ($page->save()) {
            return $this->redirect(route("page.edit", ['page' => $page]))->withMessage(['success' => trans('message.successfully_created_page')]);
        } else {
            return $this->redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Page $page)
    {
        if($request->wantsJson()){
            return response()->json($page);
        }

        $this->view->title(trans('page.view_page'));
        return $this->view->render('pages/view', ['page' => $page]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Page $page)
    {

        $this->view->js('resources/js/pages.js');

        $this->view->title(trans('page.edit_page'));

        return $this->view->render('pages/form', [
            'page' => $page,
            'all_page' => Page::all(),
            'page_templates' => (new \App\Libs\Theme($request->settings['theme']))->templates(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {

        $request->validate(Page::$rules);

        $page->fill($request->all());

        $page->slug = str_slug($request->input('name'), "-");
        $page->parent_id = $request->input('parent_select') == 0 ? NULL : $request->input('parent_id');
        $page->page = clean($request->input('page'));

        $this->uploadImage($page);

        if ($page->save()) {
            return $this->redirect(route("page.edit", ['page' => $page]))->withMessage(['success' => trans('message.successfully_updated_page')]);
        } else {
            return $this->redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }


    public function setHomePage($id)
    {

        if (\App\Model\Settings::where("setting", "home_page")->update(['value' => $id])) {
            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_set_homepage')]);
        } else {
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }


    /**
     * Remove the specified resource from database.
     *
     * @param  \App\Model\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {

        if ($page->delete()) {
            return $this->redirect(route("page.index"))->withMessage(['success' => trans('message.successfully_deleted_page')]);
        }


        return $this->redirect(route("page.index"))->withMessage(['danger' => trans('message.something_went_wrong')]);
    }




    public function reorder()
    {

        try {

            $order = json_decode($this->request->input("order"), true);

            for ($i = 0; $i < count($order); $i++) {
                $page = \App\Model\Page::find($order[$i]);
                $page->queue = $i;

                $page->save();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
