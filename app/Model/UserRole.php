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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'rights',
    ];
	
	public function users(){
		return $this->hasMany(\App\Model\User::class,'role_id','id');
	}

    public function addRight($right){
        $all_rights = $this->rights;
        array_push($all_rights, $right);
        $this->rights = $all_rights;
    }

    public function isAdminRole(){
        return $this->rights? in_array('admin_area',$this->rights) : false;
    }

}
