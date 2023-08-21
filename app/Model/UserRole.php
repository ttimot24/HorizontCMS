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
		return $this->hasMany(\App\Model\User::class,'role_id','id');
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

    public function addRight($right){
        $all_rights = $this->getRightsAttribute();
        array_push($all_rights, $right);
        $this->setRightsAttribute($all_rights);
    }

    public function isAdminRole(){
        $roles = $this->getRightsAttribute();

        return $roles? in_array('admin_area',$roles) : false;
    }

}
