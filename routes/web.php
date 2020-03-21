<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//GET GROUPS THROUGH USER
Route::get('grupos', function() {
	$groups=App\User::find(1)->groups()->get();
	dd($groups);
});

//GET USUARIOS THROUGH GROUP
Route::get('users', function() {
	$users=App\Group::find(1)->users()->get();
	dd($users);
});

//GET NOTES THROUGH USER GROUPS
Route::get('notes', function() {
	$var=App\GroupUser::where('group_id',4)->where('user_id',2)->first();
	dd($var->notes);
});

//GET USER GROUPS THROUGH NOTE
Route::get('groupuser-note', function() {
	$var=App\Note::find(1)->groupUser;
	dd($var);
});

//GET USER THROUGH USER GROUPS
Route::get('user-groupuser', function() {
	$var=App\GroupUser::where('group_id',4)->where('user_id',2)->first();
	dd($var->user);
});

//GET USER GROUPS THROUGH USER
Route::get('groupsusers-user', function() {
	$var=App\User::find(1)->addUserGroups;
	dd($var);
});


