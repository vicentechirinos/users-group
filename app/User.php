<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*RELATIONSHIP*/

    public function groups(){
        return $this->belongsToMany('App\Group')->using('App\GroupUser')->withPivot('parent_user','start_date','status');
    }

    public function createGroups(){
        return $this->hasMany('App\Group');
    }

    public function addUserGroups(){
        return $this->hasMany('App\GroupUser','parent_user');
    }

    public static function userExistInGroup($user_id, $group_id){
        return !empty(User::findOrFail($user_id)->groups()->where('group_id',$group_id)->first()) ? true : false;
    }

    public static function userActiveInGroup($user_id, $group_id){
        return !empty(User::findOrFail($user_id)->groups()->where('group_id',$group_id)->where('status',1)->first()) ? true : false;
    }


}
