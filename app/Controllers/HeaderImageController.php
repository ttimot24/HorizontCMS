<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;

use App\Model\HeaderImage;
use Illuminate\Support\Facades\Storage;

class HeaderImageController extends Controller
{

    protected $imagePath = 'images/header_images';

    public function before()
    {
        \File::ensureDirectoryExists($this->imagePath . '/thumbs');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->view->title(trans('Header Images'));
        return $this->view->render('media/header_images', [
            'slider_images' => HeaderImage::getActive()->get(),
            'slider_disabled' => HeaderImage::getInactive()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function addToSlider($id)
    {

        $header_image = \App\Model\HeaderImage::find($id);
        $header_image->active = 1;

        if ($header_image->save()) {
            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_added_headerimage')]);
        } else {
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }

    public function removeFromSlider($id)
    {

        $header_image = \App\Model\HeaderImage::find($id);
        $header_image->active = 0;

        if ($header_image->save()) {
            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_added_headerimage')]);
        } else {
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }

        return $this->redirectToSelf();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $header_image = new HeaderImage($request->all());

        if ($request->hasFile('up_file')) {

            $header_image->image = str_replace($this->imagePath . "/", "", $request->up_file->store($this->imagePath));
        }

        if ($header_image->save()) {
            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_added_headerimage')]);
        } else {
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }

        return $this->redirectToSelf();
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $header_image = \App\Model\HeaderImage::find($id);
        $header_image->title = $request->input('title');
        $header_image->description = $request->input('description');

        if ($header_image->save()) {
            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_added_headerimage')]);
        } else {
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }

        return $this->redirectToSelf();
    }


    /**
     * Remove the specified resource from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (HeaderImage::find($id)->delete()) {
            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_deleted_blogpost')]);
        }


        return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
    }
}
