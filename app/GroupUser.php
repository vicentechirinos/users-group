<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    protected $table='group_user';
    protected $fillable=[
    	'group_id','user_id','parent_user','start_date','status',
    ];

    /*RELATIONSHIP*/

    public function user(){
    	return $this->belongsTo('App\User','parent_user');
    }

    public function notes(){
    	return $this->hasMany('App\Note','group_id','group_id','user_id','user_id');
    	//  								fk       local_key     fk     local_key
    }
}
