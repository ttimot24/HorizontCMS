<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function blogposts()
    {
        return $this->hasMany(\App\Model\Blogpost::class, 'author_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(\App\Model\UserRole::class, 'role_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(\App\Model\BlogpostComment::class, 'user_id', 'id');
    }

    public function hasRole($role)
    {
        $rights = json_decode($this->role->rights);

        if (!isset($rights) || $rights == null || $rights == '') {
            return false;
        }

        return in_array($role, $rights);
    }

    /**
     * Checking that the user role which the user assegned to,
     * has the right to enter into the admin area. Therefore
     * the user is an admingroup (default: editor, manager, admin) user.
     * Don't mix up with Admin as a role!
     */
    public function isAdmin()
    {
        return $this->hasRole('admin_area');
    }

    /**
     * https://erikbelusic.com/tracking-if-a-user-is-online-in-laravel/.
     */
    public function isOnline()
    {
        return Cache::has('user-is-online-'.$this->id);
    }

    public function getThumb()
    {
        if (file_exists('storage/images/users/thumbs/'.$this->image) && $this->image != '') {
            return url('storage/images/users/thumbs/'.$this->image);
        } else {
            return $this->getImage();
        }
    }

    public function getImage()
    {
        if (file_exists('storage/images/users/'.$this->image) && $this->image != '') {
            return url('storage/images/users/'.$this->image);
        } else {
            return url('resources/images/icons/profile.png');
        }
    }
}
