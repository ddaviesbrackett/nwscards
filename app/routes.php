<?php

Route::get('/', function(){
	return Response::json(Input::all());
});

Route::get('/new', 'OrderController@getNew');
Route::post('/new', array('before' => 'csrf', 'uses' =>'OrderController@postNew'));

