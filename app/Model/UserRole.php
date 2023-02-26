<?php

namespace App\Model;

use \App\Libs\Model;

class UserRole extends Model {
   
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

	
	public function users(){
		
		$this->hasMany(\App\Model\User::class,'id','rank');
	}


	/**
    * Accessor for rights
    */
    public function getRightsAttribute(){
    	return json_decode($this->attributes['rights']);
    }

	/**
    * Mutator for rights
    */
    public function setRightsAttribute($value){
    	$this->attributes['rights'] = json_encode($value);
    }

    public function isAdminRole(){
        $roles = $this->getRightsAttribute();

        return $roles? in_array('admin_area',$roles) : false;
    }

}
