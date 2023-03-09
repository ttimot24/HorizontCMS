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
        if (!file_exists("storage/images/header_images")) {
            \File::makeDirectory("storage/images/header_images", $mode = 0777, true, true);
        }
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

        if ($this->request->isMethod('POST')) {
            $header_image = new HeaderImage($this->request->all());

            if ($this->request->hasFile('up_file')) {

                $header_image->image = str_replace($this->imagePath . "/", "", $this->request->up_file->store($this->imagePath));
            }

            if ($header_image->save()) {
                return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_added_headerimage')]);
            } else {
                return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
            }
        }

        return $this->redirectToSelf();
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
        //
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
        $header_image = \App\Model\HeaderImage::find($id);
        $header_image->title = $this->request->input('title');
        $header_image->description = $this->request->input('description');

        if ($header_image->save()) {
            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_added_headerimage')]);
        } else {
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }

        return $this->redirectToSelf();
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
        //
    }


    /**
     * Remove the specified resource from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (HeaderImage::find($id)->delete()) {
            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_deleted_blogpost')]);
        }


        return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
    }
}
