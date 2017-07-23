<?php

namespace App\Libs;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Libs\View;
use Illuminate\Http\Request;

class Controller extends BaseController{
	
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Request $request){
    	$this->request = $request;	

        $this->view = new View();

        

        foreach(app()->plugins as $plugin){

                foreach($plugin->getRegister('injectJs',[]) as $js){
                       $this->view->data['jsplugins'][] = "plugins/".$plugin->root_dir.'/'.$js; 
                }

        }


    }

    public function redirect($location){
    	return redirect($location);
    }

    public function redirectToSelf(){
        return redirect()->back();
    }

    public function insideLink($location){
    	return redirect(\Config::get('horizontcms.backend_prefix')."/".$location);
    }


}
