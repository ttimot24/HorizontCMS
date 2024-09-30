<?php

namespace App\Controllers;

use App\Controllers\Trait\UploadsImage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
    public function index(Request $request)
    {
        $activeImages = HeaderImage::active()->orderBy('order', 'ASC')->get();

        if($request->wantsJson()){
            return response()->json($activeImages);
        }

        return view('media.header_images', [
            'slider_images' => $activeImages,
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
            return redirect()->back()->withMessage(['success' => trans('message.successfully_added_headerimage')]);
        } else {
            return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }

    public function removeFromSlider($id)
    {

        $header_image = \App\Model\HeaderImage::find($id);
        $header_image->active = 0;

        if ($header_image->save()) {
            return redirect()->back()->withMessage(['success' => trans('message.successfully_added_headerimage')]);
        } else {
            return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }

        return redirect()->back();
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
            return redirect()->back()->withMessage(['success' => trans('message.successfully_added_headerimage')]);
        } 
        
        return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
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
            return redirect()->back()->withMessage(['success' => trans('message.successfully_added_headerimage')]);
        }

        return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);

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
            return redirect()->back()->withMessage(['success' => trans('message.successfully_deleted_blogpost')]);
        }

        return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
    }
}
