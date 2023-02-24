<?php

namespace App\Model;

use \App\Libs\Model;

class BlogpostComment extends Model{
    
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment',
    ];

	public function blogpost(){
		return $this->belongsTo(\App\Model\Blogpost::class,'blogpost_id','id');
	}

	public function user(){
		return $this->belongsTo(\App\Model\User::class,'user_id','id');
	}




}
