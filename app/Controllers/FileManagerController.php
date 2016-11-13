<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;


class FileManagerController extends Controller{
 


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug){


        $current_dir = $this->request->get('path')==NULL? storage_path() : storage_path().DIRECTORY_SEPARATOR.$this->request->get('path');


        $this->view->title(trans('File Manager'));
        return $this->view->render('media/filemanager',[
                'old_path' => $this->request->get('path'),
                'current_dir' => $current_dir,
                'files' => array_slice(scandir($current_dir),2),
                'allowed_extensions' => [
                                          'image' => ['jpg','png','jpeg']
                                        ],
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //
    }


    /**
     * Remove the specified resource from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        
    }


    public function browse(){
        return "asd";
    }


    public function upload(){
        
    }


}
