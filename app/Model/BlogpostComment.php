<?php

namespace App\Model;

use App\Model\Trait\HasAuthor;
use \Illuminate\Database\Eloquent\Model;

class BlogpostComment extends Model {

    use HasAuthor;
    
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
		return $this->author();
	}

}
