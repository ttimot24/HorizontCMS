<?php

namespace App\Model;

use \Illuminate\Database\Eloquent\Model;

class UserRole extends Model {
   
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'rights'
    ];

    protected $casts = [
        'rights' => 'array',
    ];
	
	public function users(){
		return $this->hasMany(\App\Model\User::class,'role_id','id');
	}

    public function addRight($right){
        $all_rights = $this->getRightsAttribute();
        array_push($all_rights, $right);
        $this->setRightsAttribute($all_rights);
    }

    public function isAdminRole(){
        $roles = $this->attributes['rights'];

        return $roles? in_array('admin_area',$roles) : false;
    }

}
