<?php 

namespace App;
 
 
class HorizontCMS extends \Illuminate\Foundation\Application{
 
 	public $plugins = null;
   
    public static function isInstalled(){
        return file_exists(".env") || env("INSTALLED","")!="";
    }

    public function publicPath(){

 		return $this->basePath.DIRECTORY_SEPARATOR;
    }


}