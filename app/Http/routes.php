<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('playlist');
});

Route::get('playlist', 'PlaylistController@index');
Route::get('votes', function() {
	return view('votes.index');
});


// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Song
Route::resource('songs', 'SongController');

// User Profile
Route::resource('userprofile', 'UserProfileController');

// Userlist
Route::resource('admin/userlist',"UserListController");

// Change password
Route::get('changepassword','ChangePasswordController@index');
Route::post('changepassword','ChangePasswordController@store');

// Admin
Route::post('admin/changeStatus', 'UserListController@changeStatus');
Route::post('admin/changeRole', 'UserListController@changeRole');
Route::post('admin/deleteUser', 'UserListController@deleteUser');
Route::get('admin/searchuser', 'UserListController@searchUser');

Route::post('admin/filter','UserListController@filter');
Route::get('admin/filter','UserListController@filter');

Route::get('admin/config','ConfigController@index');
Route::post('admin/config','ConfigController@store');

//Timer
Route::get('timer','TimerController@index');
Route::get('songarray','SongArrayController@index');

//Block song router (admin)
Route::get('blocksong', 'AdminController@getBlockSong');
Route::post('blocksong', 'AdminController@postBlockSong');
Route::get('blockedSongList', 'AdminController@getBlockedSongList');
Route::get('unblocksong', 'AdminController@getUnblockSong');
