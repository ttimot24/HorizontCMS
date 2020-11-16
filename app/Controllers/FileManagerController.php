<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Http\File;

class FileManagerController extends Controller{
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug){


        $mode = $this->request->get('mode');

        $current_dir = str_replace_first("storage/","",$this->request->get('path')==NULL? "" : ltrim($this->request->get('path'),"/"));

        $data = [
                'old_path' => ($current_dir==""? "":$current_dir."/"),
                'current_dir' => $current_dir,
                'dirs' => array_values(collect(\File::directories(storage_path($current_dir)))->map(function($dir){
                    return basename($dir);
                })->toArray()),
                'files' => array_values(collect(\File::files(storage_path($current_dir)))->map(function($file){
                    return basename($file);
                })->toArray()),
                'allowed_extensions' => [
                                          'image' => ['jpg','png','jpeg']
                                        ],
                'mode' => $mode,
            ];


        if($this->request->ajax()){
            return response()->json($data);
        }

        $this->view->title(trans('File Manager'));
        return $this->view->render($mode=='embed'? 'media/embed' : 'media/fmframe',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileupload(){
        
        
        if($this->request->isMethod('POST')){

            if ($this->request->hasFile('up_file')){

                foreach($this->request->up_file as $file){
                    
                    if(!\Security::isExecutable($file)){
                        $images[] = $file->store(str_replace("storage/", "", $this->request->input('dir_path')));
                    }
                }

                if($this->request->ajax()){
                    return response()->json(['success' => 'Files uploaded successfully!', 'uploadedFileNames' => $images ]);
                }
                   
                return $this->redirectToSelf()->withMessage(['success' => 'Files uploaded successfully!']);

            }else{

                if($this->request->ajax()){
                    return response()->json(['danger' => 'Could not upload files!']);
                }

                return $this->redirectToSelf()->withMessage(['danger' => 'Could not upload files!']);
            }

        }

        if($this->request->ajax()){
            return response()->json(['warning' => 'Only POST method allowed!']);
        }

        return $this->redirectToSelf()->withMessage(['warning' => 'Only POST method allowed!']);

    }


    public function download(){

        if($this->request->has('file')){

            $file = $this->request->input('file');

            $headers = [
                  'Content-Type' => 'application/*',
            ];

            return response()->download($file, basename($file), $headers);

        }

        return $this->redirectToSelf()->withMessage(['warning' => 'Bad request!']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function newFolder(){
        
        if($this->request->isMethod('POST')){
            
            $directory = "storage/".str_replace("storage/","",$this->request->input('dir_path'))."/".$this->request->input('new_folder_name');

            if(!file_exists($directory)){
                \File::makeDirectory($directory , $mode = 0777, true, true);
               
                if($this->request->ajax()){
                    return response()->json(['success' => 'Folder created successfully!']);
                }

                return $this->redirectToSelf()->withMessage(['success' => 'Folder created successfully!']);
          
            }else{

                if($this->request->ajax()){
                    return response()->json(['danger' => 'Folder already exists!']);
                }
              
                return $this->redirectToSelf()->withMessage(['danger' => 'Folder already exists!']);
            }
        }

    }


    /**
     * Remove the specified resource from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(){


         $toDelete = str_replace("storage/","",$this->request->input('file'));

         if(!file_exists('storage/'.$toDelete)){
            if($this->request->ajax()){
                return response()->json(['warning' => trans("File ".$toDelete." doesn't exists")]);
            }

             return $this->redirectToSelf()->withMessage(['warning' => trans("File ".$toDelete." doesn't exists")]);
         }

                
         if(!is_dir('storage/'.$toDelete) && Storage::delete($toDelete)){

                if($this->request->ajax()){
                    return response()->json(['success' => trans('File deleted successfully')]);
                }

             return $this->redirectToSelf()->withMessage(['success' => trans('File deleted successfully')]);
         }else if(is_dir('storage/'.$toDelete) && Storage::deleteDirectory($toDelete)){

                if($this->request->ajax()){
                    return response()->json(['success' => trans('Directory deleted successfully')]);
                }

             return $this->redirectToSelf()->withMessage(['success' => trans('Directory deleted successfully')]);
         }else{

            if($this->request->ajax()){
                return response()->json(['danger' => trans('message.something_went_wrong')]);
            }

             return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
         }

    }



    public function upload(){
        
        if($this->request->isMethod('POST')){

            if ($this->request->hasFile('upload')){

                $image = $this->request->upload->store('images/'.$this->request->input('module'));

               if($image){
                   // if($this->request->ajax()){
                        return response()->json(["uploaded"=>1, "fileName"=> basename($image), "url" => "storage/".$image]);
/*                    }else{
                        return "Image uploaded successfully!";*/
                    //}
               }else{
                   /* if($this->request->ajax()){*/
                        return response()->json(["uploaded"=>0]);
                   /* }else{
                        return "Something went wrong!";
                    }*/
               }


            }

        }

    }


    public function rename(){

        if($this->request->isMethod('POST')){

            $new_file = $this->request->input('new_file');

            if(!\Security::isExecutable($new_file) && \Storage::move($this->request->input('old_file'), $new_file)){
                if($this->request->ajax()){
                    return response()->json(['success' => trans('File successfully renamed!')]);
                }
            }else{
                if($this->request->ajax()){
                    return response()->json(['danger' => trans('message.something_went_wrong')]);
                }
            }

        }

    }

}
