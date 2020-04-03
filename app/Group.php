<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /*RELATIONSHIP*/

    protected $fillable=[
    	'name','user_id',
    ];

    public function users(){
        return $this->belongsToMany('App\User')->using('App\GroupUser')->withPivot('parent_user','start_date','status');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
    
}
