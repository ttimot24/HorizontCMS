<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;


class PluginController extends Controller{
 

    public function before(){
        if(!file_exists("plugins")){
            \File::makeDirectory("plugins", $mode = 0777, true, true);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug){

        $this->view->title(trans('Applications'));
        return $this->view->render('plugin/index',[
                                                'all_plugin' => collect(\File::directories(base_path().DIRECTORY_SEPARATOR."plugins"))->map(function($dir){
                                                    return new \App\Model\Plugin(str_replace(base_path().DIRECTORY_SEPARATOR."plugins".DIRECTORY_SEPARATOR,"",$dir));
                                                }),

                                                'zip_enabled' => class_exists('ZipArchive'),

            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function onlinestore(){

        $this->view->title(trans('App center'));
        return $this->view->render('plugin/store',[
                                               'online_plugins' => json_decode(file_get_contents('http://www.eterfesztival.hu/hcms_online_store/get_plugins.php')),

            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function install($plugin_name){

       $path_to_db = "plugins".DIRECTORY_SEPARATOR.$plugin_name.DIRECTORY_SEPARATOR."database";
       
       if(file_exists($path_to_db) && is_dir($path_to_db)){

            \Artisan::call("migrate",['--path'=> $path_to_db.DIRECTORY_SEPARATOR."migrations"]);
            \Artisan::call('db:seed', ['--class' => 'Plugins\\'.$plugin_name.'\\database\\seeds\\PluginSeeder']);

       }


        $plugin = new \App\Model\Plugin($plugin_name);
        unset($plugin->info,$plugin->config);
        $plugin->area = 0;
        $plugin->permission = 0;
        $plugin->table_name = "";
        $plugin->active = 1;


        if($plugin->save()){
            return $this->redirectToSelf()->withMessage(['success' => trans('Succesfully installed '.$plugin_name)]);
        }else{
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }

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


    public function upload(){
        
    }


}
