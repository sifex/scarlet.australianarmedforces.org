<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::get('/', function () {
	return view('index');
});

Route::get('/key/', function() {
	return view('key.index');
});

/* ------------- API --------------- */

// Scarlet Test API
Route::get('/api/', function() {
	return response()->json(['name' => 'Scarlet API', 'version' => '1']);
});

Route::get('/api/version/', function() {
	return '1.0';
});

// ADD
Route::get('/api/user/add/{username}/{clanID}/', 'UserController@add');

// INFO
Route::get('/api/user/info/{var}/{key}/', 'UserController@info');

// SET INSTALL
Route::post('/api/user/install/{key}/', 'UserController@install');

Route::get('/asd/', 'UserController@post');
