<?php 

namespace App;
 
 
class HorizontCMS extends \Illuminate\Foundation\Application{
 
 	public $plugins = null;
   
    public static function isInstalled(){
        return file_exists(base_path(".env")) || env("INSTALLED","")!="";
    }

    public function publicPath(){

 		return $this->basePath.DIRECTORY_SEPARATOR;
    }


}