<?php

namespace App\Model;

use App\Model\Trait\HasImage;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {

    use Notifiable, Authenticatable, Authorizable, CanResetPassword;
    use HasImage;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username' ,'email', 'password', 'phone', 'role_id', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $defaultImage = "resources/images/icons/profile.png";

    protected $imageDir = "storage/images/users";

    public static function findBySlug($slug){

        $user = self::where('slug',$slug)->get()->first();

        if($user!=NULL){
            return $user;
        }else{

            foreach (self::where('slug',NULL)->orWhere('slug',"")->get() as $user) {
                if(str_slug($user->username)==$slug){
                    return $user;
                }
            }

        }

        return NULL;
    }


    public function blogposts(){
        return $this->hasMany(\App\Model\Blogpost::class,'author_id','id');
    }


    /**
    *
    * If the binded UserRole is missing then ithe method
    * return the default role. 
    *
    */
    public function role(){

        if(\App\Model\UserRole::find($this->role_id)==NULL){
            $this->role_id = 1;
        }
         
        return $this->belongsTo(\App\Model\UserRole::class,'role_id','id');
    }

    public function comments(){
    	return $this->hasMany(\App\Model\BlogpostComment::class,'user_id','id');
    }


    public function hasPermission($permission){

        if(!isset($this->role->rights) || $this->role->rights==NULL || $this->role->rights==""){
            return false;
        }

        return in_array($permission, $this->role->rights);
    }

    /**
    *
    * Checking that the user role which the user assegned to,
    * has the right to enter into the admin area. Therefore
    * the user is an admingroup (default: editor, manager, admin) user. 
    * Don't mix up with Admin as a role! 
    *
    */
    public function isAdmin(){
        return $this->hasPermission('admin_area');
    }


    public function isActive(){
        return $this->active==1;
    }


    /**
    *
    * https://erikbelusic.com/tracking-if-a-user-is-online-in-laravel/
    *
    */
    public function isOnline(){

    	return Cache::has('user-is-online-' . $this->id);
	}

    public function getSlug(){
        return ($this->slug!=NULL && $this->slug!="")? $this->slug : str_slug($this->username);
    }

    /**
    * Mutator for passwords
    */
    public function setPasswordAttribute($value){
    	$this->attributes['password'] = \Hash::make($value);
    }


    public static function search($search_key){

        $search_key = '%'.$search_key.'%';

        return self::where('name', 'LIKE' ,$search_key)->orWhere('username', 'LIKE' ,$search_key)->orWhere('email', 'LIKE' ,$search_key)->get();

    }

}
