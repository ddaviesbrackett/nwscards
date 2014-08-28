<?php

Route::get('/', 'HomeController@getHome');

Route::get('/login', 'HomeController@getLogin');
Route::post('/login', 'HomeController@postLogin');
Route::get('/logout', 'HomeController@getLogout');

Route::get('/account', array('before' => 'auth', 'uses' => 'OrderController@getAccount'));
Route::post('/account', array('before' => 'csrf'/*auth too*/, 'uses' =>'OrderController@postAccount'));
Route::get('/new', 'OrderController@getNew');
Route::post('/new', array('before' => 'csrf', 'uses' =>'OrderController@postNew'));

Route::post('/contact', array('before' => 'csrf', 'uses' =>'HomeController@postContact'));

Route::controller('password', 'RemindersController');

View::share('dates', BaseController::getDates());