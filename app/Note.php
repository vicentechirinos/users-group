<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{

	protected $fillable=[
		'title','details','group_id','user_id','date',
	];

    /*RELATIONSHIP*/

    public function groupUser(){
    	return $this->belongsTo('App\GroupUser','group_id','group_id','user_id','user_id');
    	//  								       fk      parent_key     fk     parent_key
    }

}
