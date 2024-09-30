<?php

namespace App\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $mode = request()->get('mode');

        $current_dir = str_replace_first("storage/", "", request()->get('path') == null ? "" : ltrim(request()->get('path'), "/"));

        $data = [
            'old_path' => ($current_dir == "" ? "" : $current_dir . "/"),
            'current_dir' => $current_dir,
            'dirs' => array_values(collect(\File::directories(storage_path($current_dir)))->map(function ($dir) {
                return basename($dir);
            })->toArray()),
            'files' => array_values(collect(\File::files(storage_path($current_dir)))->map(function ($file) {
                return basename($file);
            })->toArray()),
            'allowed_extensions' => [
                'image' => ['jpg', 'png', 'jpeg']
            ],
            'mode' => $mode,
        ];


        if (request()->ajax()) {
            return response()->json($data);
        }

        return view($mode == 'embed' ? 'media.embed' : 'media.fmframe', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        if (request()->isMethod('POST')) {

            if (request()->hasFile('up_file')) {

                $dir = str_replace("storage/", "", request()->input('dir_path'));

                foreach (request()->up_file as $file) {
                    if (!\Security::isExecutable($file)) {
                        $images[] = $file->store($dir);
                    }
                }

                if (request()->ajax()) {
                    return response()->json(['success' => 'Files uploaded successfully!', 'uploadedFileNames' => $images]);
                }

                return redirect()->back()->withMessage(['success' => 'Files uploaded successfully!']);
            } else {

                if (request()->ajax()) {
                    return response()->json(['danger' => 'Could not upload files!']);
                }

                return redirect()->back()->withMessage(['danger' => 'Could not upload files!']);
            }
        }

        if (request()->ajax()) {
            return response()->json(['warning' => 'Only POST method allowed!']);
        }

        return redirect()->back()->withMessage(['warning' => 'Only POST method allowed!']);
    }


    public function download()
    {

        if (request()->has('file')) {

            $file = request()->input('file');

            $headers = [
                'Content-Type' => 'application/*',
            ];

            return response()->download($file, basename($file), $headers);
        }

        return redirect()->back()->withMessage(['warning' => 'Bad request!']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function newFolder()
    {

        if (request()->isMethod('POST')) {

            $directory = "storage/" . str_replace("storage/", "", request()->input('dir_path')) . "/" . request()->input('new_folder_name');

            if (!file_exists($directory)) {
                \File::makeDirectory($directory, $mode = 0777, true, true);

                if (request()->ajax()) {
                    return response()->json(['success' => 'Folder created successfully!']);
                }

                return redirect()->back()->withMessage(['success' => 'Folder created successfully!']);
            } else {

                if (request()->ajax()) {
                    return response()->json(['danger' => 'Folder already exists!']);
                }

                return redirect()->back()->withMessage(['danger' => 'Folder already exists!']);
            }
        }
    }


    /**
     * Remove the specified resource from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {

        $toDelete = str_replace("storage/", "", request()->input('file'));

        if (!file_exists('storage/' . $toDelete)) {
            if (request()->ajax()) {
                return response()->json(['warning' => trans("File " . $toDelete . " doesn't exists")]);
            }

            return redirect()->back()->withMessage(['warning' => trans("File " . $toDelete . " doesn't exists")]);
        }


        if (!is_dir('storage/' . $toDelete) && Storage::delete($toDelete)) {

            if (request()->ajax()) {
                return response()->json(['success' => trans('File deleted successfully')]);
            }

            return redirect()->back()->withMessage(['success' => trans('File deleted successfully')]);
        } else if (is_dir('storage/' . $toDelete) && Storage::deleteDirectory($toDelete)) {

            if (request()->ajax()) {
                return response()->json(['success' => trans('Directory deleted successfully')]);
            }

            return redirect()->back()->withMessage(['success' => trans('Directory deleted successfully')]);
        } else {

            if (request()->ajax()) {
                return response()->json(['danger' => trans('message.something_went_wrong')]);
            }

            return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }



    public function upload()
    {

        if (request()->isMethod('POST')) {

            if (request()->hasFile('upload')) {

                $image = request()->upload->store('images/' . request()->input('module'));

                if ($image) {
                    // if($this->request->ajax()){
                    return response()->json(["uploaded" => 1, "fileName" => basename($image), "url" => "storage/" . $image]);
                    /*                    }else{
                        return "Image uploaded successfully!";*/
                    //}
                } else {
                    /* if($this->request->ajax()){*/
                    return response()->json(["uploaded" => 0]);
                    /* }else{
                        return "Something went wrong!";
                    }*/
                }
            }
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rename()
    {

        $new_file = trim(request()->input('new_file'), "/");

        if (!\Security::isExecutable($new_file) && \Storage::move(request()->input('old_file'), $new_file)) {
            if (request()->ajax()) {
                return response()->json(['success' => trans('File successfully renamed!')]);
            }
        } else {
            if (request()->ajax()) {
                return response()->json(['danger' => trans('message.something_went_wrong')]);
            }
        }
    }
}
