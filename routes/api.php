<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login','UserController@login');

Route::middleware('auth:api')->group(function(){
	Route::get('logout','UserController@logout');
	Route::resource('user','UserController')->except('create','edit','destroy');
	Route::resource('group','GroupController')->except('create','edit','destroy');
	Route::get('groupscreatedbyuser/{id}','GroupController@groupsCreatedByUser');
	Route::get('userassociatedgroup/{id}','UserController@userAssociatedGroup');
	Route::post('parentusercreateusersgroup','UserController@parentUserCreateUsersGroup');
	Route::get('getparentusercreateusersgroup/{id}','UserController@getParentUserCreateUsersGroup');
	Route::post('signinusergroup','UserController@userSignInGroup');
	Route::post('createnoteingroup','NoteController@createNoteInGroup');
});
