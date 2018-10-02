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

        $repo_status = true;

        try{
            $plugins = json_decode(file_get_contents(\Config::get('horizontcms.sattelite_url').'/get_plugins.php'));
        }catch(\ErrorException $e){
            $plugins = [];
            $repo_status = false;
        }



        return $this->view->render('plugin/store',[ 'online_plugins' => $plugins, 'repo_status' => $repo_status ]);
    }


    public function downloadPlugin($plugin_name){

        $temp_zip = "framework".DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR.$plugin_name.".zip";

        $status = \Storage::disk('local')->put($temp_zip, file_get_contents(\Config::get('horizontcms.sattelite_url')."/download/plugin/".$plugin_name));
        chmod(storage_path().DIRECTORY_SEPARATOR.$temp_zip,0777);

        if($status){

            \Zipper::make(storage_path().DIRECTORY_SEPARATOR.$temp_zip)->folder($plugin_name)->extractTo('plugins'.DIRECTORY_SEPARATOR.$plugin_name);

            if(file_exists("plugins/".$plugin_name)){ 
                @\Storage::delete("framework".DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR.$plugin_name.".zip");
                return $this->redirectToSelf()->withMessage(['success' => trans('Succesfully downloaded '.$plugin_name)]);
            }else{
                return $this->redirectToSelf()->withMessage(['danger' => trans('Could not extract the plugin: '.$plugin_name."")]);
            }
        
        }else{
            return $this->redirectToSelf()->withMessage(['danger' => trans('Could not download the plugin: '.$plugin_name."")]);
        }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function install($plugin_name){

        try{

           $plugin = new \App\Model\Plugin($plugin_name);

           if(!$plugin->isCompatibleWithCore()){
                return $this->redirectToSelf()->withMessage(['warning' => trans('plugin.not_compatible_with_core',['min_core_ver' => $plugin->getRequiredCoreVersion()])]);
           }

           
           if($plugin->getDatabaseFilesPath()){


                \Artisan::call("migrate",['--path' => $plugin->getDatabaseFilesPath().DIRECTORY_SEPARATOR."migrations",'--no-interaction' => '','--force' => true ]);
                

                $seed_class = '\\Plugin\\'.$plugin_name.'\\Database\\Seeds\\PluginSeeder';

                if(class_exists($seed_class)){
                	\Artisan::call('db:seed', ['--class' => $seed_class, '--no-interaction' => '', '--force' => true ]);
            	}
           }


            $plugin->getRegister('onInstall',[]);
         

            //$plugin->version should be added
            unset($plugin->info,$plugin->config);
            $plugin->area = 0;
            $plugin->permission = 0;
            $plugin->tables = "";
            $plugin->active = 0;


            $plugin->save();
                

            return $this->redirectToSelf()->withMessage(['success' => trans('Succesfully installed '.$plugin_name)]);


        }catch(\Exception $e){
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong') ." ".$e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($plugin_name){
        
        $plugin = \App\Model\Plugin::where('root_dir',$plugin_name)->first();
        $plugin->active = 1;

        if($plugin->save()){
            return $this->redirectToSelf()->withMessage(['success' => trans('Succesfully activated '.$plugin_name)]);
        }else{
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($plugin_name){

        $plugin = \App\Model\Plugin::where('root_dir',$plugin_name)->first();
        $plugin->active = 0;


        if($plugin->save()){
            return $this->redirectToSelf()->withMessage(['success' => trans('Succesfully deactivated '.$plugin_name)]);
        }else{
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }

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
    public function delete($plugin){

        try{

            \App\Model\Plugin::where('root_dir',$plugin)->first()->delete();

             if(file_exists("plugins/".$plugin)){
                \Storage::disk('plugins')->deleteDirectory($plugin);
             }

        }catch(\Exception $e){
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong') . " " .$e->getMessage()]);
        }


        return $this->redirectToSelf()->withMessage(['success' => trans('Succesfully deleted the plugin!')]);
 
    }


    public function upload(){

        if ($this->request->hasFile('up_file')){

            $file_name = $this->request->up_file[0]->store('framework/temp');

        }

        $zip = new \ZipArchive;
        if ($zip->open("storage/".$file_name) === TRUE) {
            $zip->extractTo('plugins/');
            $zip->close();
            
            \Storage::delete("storage/".$file_name);

            return $this->redirectToSelf()->withMessage(['success' => trans('Succesfully uploaded the plugin!')]);
        } else {
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }


}
