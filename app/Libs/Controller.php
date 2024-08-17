<?php

namespace App\Libs;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Libs\ViewResolver;
use Illuminate\Http\Request;

abstract class Controller extends BaseController {
	
    protected $request;
    protected $view;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Request $request,ViewResolver $viewResolver){
    	$this->request = $request;	

        $this->view = $viewResolver;
    }

    public function redirect($location){
    	return redirect($location);
    }

    public function redirectToSelf(){
        return redirect()->back();
    }

}
