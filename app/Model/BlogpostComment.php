<?php

namespace App\Model;

use \App\Libs\Model;

class BlogpostComment extends Model {
    
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'blogpost_id', 'comment', 'active',
    ];

	public function blogpost(){
		return $this->belongsTo(\App\Model\Blogpost::class,'blogpost_id','id');
	}

    // TODO Use HasAuthor trait 
	public function user(){
		return $this->belongsTo(\App\Model\User::class,'user_id','id');
	}

}
