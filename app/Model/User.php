<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username' ,'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function blogposts(){
        return $this->hasMany(\App\Model\Blogpost::class,'author_id','id');
    }

    public function role(){
        return $this->belongsTo(\App\Model\UserRole::class,'rank','id');
    }

    public function comments(){
    	return $this->hasMany(\App\Model\UserRole::class,'user_id','id');
    }

    public function getThumb(){

        if(file_exists("storage/images/users/thumbs/".$this->image) && $this->image!=""){
            return url("storage/images/users/thumbs/".$this->image);
        }else{
            return $this->getImage();
        }

    }

    public function getImage(){

        if(file_exists("storage/images/users/".$this->image)  && $this->image!=""){
            return url("storage/images/users/".$this->image);
        }else{
            return url("resources/images/icons/profile.png");
        }

    }


}
