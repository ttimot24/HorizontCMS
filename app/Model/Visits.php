<?php

namespace App\Model;

use \App\Libs\Model;

class Visits extends Model{
    
    protected $table = 'visits';
    public $timestamps = false;


    public static function newVisitor(\Illuminate\Http\Request $request){
    	$visit = null;

    	try{

    		$visit = new Visits();
    		$visit->date = date('Y-m-d');
    		$visit->time = date('H:i:s');
    		$visit->ip = $request->ip();
    		$visit->host_name = gethostbyaddr($request->ip());
    		$visit->client_browser = $request->header('user_agent');

    		$visit->save();

    	}catch(\Exception $exception){
    		//throw $exception;
    		//do nothing
    	}

    	return $visit;
    }


	public function getCreatedAtAttribute(){	
        return new \Carbon\Carbon($this->date." ".$this->time);
    }

}
