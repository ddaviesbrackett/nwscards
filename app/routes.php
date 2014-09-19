<?php
//main page
Route::get('/', 'HomeController@getHome');

//login/logout
Route::get('/login', 'HomeController@getLogin');
Route::post('/login', 'HomeController@postLogin');
Route::get('/logout', 'HomeController@getLogout');

//account creation/view/update
Route::get('/account', array('before' => 'auth', 'uses' => 'OrderController@getAccount'));
Route::post('/account', array('before' => 'csrf'/*auth too*/, 'uses' =>'OrderController@postAccount'));
Route::get('/new', 'OrderController@getNew');
Route::post('/new', array('before' => 'csrf', 'uses' =>'OrderController@postNew'));

//contact form
Route::post('/contact', array('before' => 'csrf', 'uses' =>'HomeController@postContact'));

//password reminders
Route::controller('password', 'RemindersController');

//stripe webhooks
Route::post('/stripe/webhook', 'StripeWebHookController@handleWebhook');

//Administrator treehouse
Route::get('/admin/caft', ['before'=>['auth','admin'], 'uses' => 'AdminController@getCaft']);
Route::get('/admin/totals', ['before'=>['auth','admin'], 'uses' => 'AdminController@getTotals']);
Route::get('/admin/orders', ['before'=>['auth','admin'], 'uses' => 'AdminController@getOrders']);
Route::get('/admin/order/{id}', 
	[
		'before'=>['auth','admin'], 
		'uses' => 'AdminController@getOrder', 
		'as' =>'admin-order',
	]);

//stuff everything needs
View::share('dates', BaseController::getFormattedDates());