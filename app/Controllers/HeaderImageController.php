<?php

namespace App\Controllers;

use App\Controllers\Trait\UploadsImage;
use Illuminate\Http\Request;
use App\Libs\Controller;

use App\Model\HeaderImage;

class HeaderImageController extends Controller
{

    use UploadsImage;

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
            'slider_images' => HeaderImage::active()->orderBy('order', 'ASC')->get(),
            'slider_disabled' => HeaderImage::inactive()->orderBy('order','ASC')->get(),
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
        $header_image->author()->associate($request->user());

        $this->uploadImage($header_image);

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
    public function update(Request $request, HeaderImage $headerimage)
    {

        $headerimage->fill($request->all());
        $headerimage->author()->associate($request->user());

        if($headerimage->save()) {
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
    public function destroy(HeaderImage $headerimage)
    {

        if ($headerimage->delete()) {
            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_deleted_blogpost')]);
        }


        return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
    }
}
