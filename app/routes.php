<?php
//main page1
Route::get('/', 'HomeController@getHome');

Route::get('/test', 'HomeControllerTest@getHome');
//Route::get('/testorders', 'HomeControllerTest@generateOrders');

//login/logout
Route::get('/login', 'HomeController@getLogin');
Route::post('/login', 'HomeController@postLogin');
Route::get('/logout', 'HomeController@getLogout');

//ultra-special login-and-resume from an email link
Route::get('/email-resume', ['uses' => 'OrderController@EmailResume']);

//account creation/view/update
Route::get('/account', array('before' => 'auth', 'uses' => 'OrderController@getAccount'));
Route::get('/account/extracards', array('before' => 'auth', 'uses' => 'OrderController@getAccount')); //with onetime form showing
Route::post('/account', array('before' => ['csrf', 'auth'], 'uses' =>'OrderController@postAccount'));
Route::get('/new', 'OrderController@getNew');
Route::post('/new', array('before' => 'csrf', 'uses' =>'OrderController@postNew'));

Route::get('/edit', array('before' => 'auth', 'uses' => 'OrderController@getEdit'));
Route::post('/edit', array('before' => ['auth', 'csrf'], 'before' => 'csrf', 'uses' =>'OrderController@postEdit'));
Route::get('/Suspend', array('before' => 'auth', 'uses' =>'OrderController@Suspend'));
Route::get('/Resume', array('before' => 'auth', 'uses' =>'OrderController@Resume'));
Route::get('/account/onetime', ['before'=>'auth', 'uses' => 'OrderController@getOnetime', 'as' => 'account-getonetime']);
Route::post('/account/onetime', ['before'=>['auth', 'csrf'], 'uses' => 'OrderController@postOneTime', 'as' => 'account-postonetime']);

//contact form
Route::post('/contact', array('before' => 'csrf', 'uses' =>'HomeController@postContact'));

//password reminders
Route::controller('password', 'RemindersController');

//stripe webhooks
Route::post('/stripe/webhook', 'StripeWebHookController@handleWebhook');

//profit tracking
Route::get('/tracking/leaderboard', 'TrackingController@getLeaderboard', ['as' => 'leaderboard']);
Route::get('/tracking/', 'TrackingController@getLeaderboard', ['as' => 'leaderboard']);
Route::get('/tracking/{bucketname}', 'TrackingController@getBucket', ['as' => 'tracking-bucket']);

//Administrator treehouse
Route::model('dateforprofit', 'CutoffDate');
Route::model('expense', 'Expense');
Route::model('sale', 'Pointsale');

Route::get('/admin/caft/{id}', ['before'=>['auth','admin'], 'uses' => 'AdminController@getCaft', 'as' => 'admin-caft']);
Route::get('/admin/orders', ['before'=>['auth','admin'], 'uses' => 'AdminController@getOrders']);
Route::get('/admin/order/{id}', 
	[
		'before'=>['auth','admin'], 
		'uses' => 'AdminController@getOrder', 
		'as' =>'admin-order',
	]);
Route::get('/admin/impersonate', 
	[
		'before'=>['auth','admin'], 
		'uses' => 'AdminController@getImpersonate', 
		'as' =>'admin-impersonate',
	]);
Route::get('/admin/impersonate/{id}', 
	[
		'before'=>['auth','admin'], 
		'uses' => 'AdminController@doImpersonate', 
		'as' =>'admin-doimpersonate',
	]);
Route::get('/admin/unimpersonate/', 
	[
		'before'=>['auth'], 
		'uses' => 'AdminController@unImpersonate', 
		'as' =>'admin-unimpersonate',
	]);

Route::get('/admin/orderprofits/{dateforprofit}', ['before'=>['auth','admin'], 'uses' => 'AdminController@getProfitSettingForm', 'as' => 'admin-getprofit']);
Route::post('/admin/orderprofits/{dateforprofit}', ['before'=>['auth','admin', 'csrf'], 'uses' => 'AdminController@postProfitSettingForm', 'as' => 'admin-postprofit']);

Route::get('/admin/caftfile/{dateforprofit}', ['before'=>['auth','admin'], 'uses' => 'CAFTGenerationController@getResult', 'as' => 'admin-getcaftfile']);

Route::get('/admin/pointsale', ['before'=>['auth','admin'], 'uses' => 'AdminController@getNewSaleForm', 'as' => 'admin-getnewsale']);
Route::post('/admin/pointsale', ['before'=>['auth','admin', 'csrf'], 'uses' => 'AdminController@postNewSaleForm', 'as' => 'admin-postnewsale']);

Route::get('/admin/expenses', ['before'=>['auth','admin'], 'uses' => 'ExpenseController@getExpenses', 'as' => 'admin-getexpenses']);
Route::post('/admin/expenses', ['before'=>['auth','admin'], 'uses' => 'ExpenseController@postExpense', 'as' => 'admin-postexpense']);

Route::get('/admin/expenses/{expense}/edit', ['before'=>['auth','admin'], 'uses' => 'ExpenseController@getEditExpense', 'as' => 'admin-geteditexpense']);
Route::post('/admin/expenses/{expense}/edit', ['before'=>['auth','admin'], 'uses' => 'ExpenseController@postEditExpense', 'as' => 'admin-posteditexpense']);

Route::get('/admin/expenses/{expense}/delete', ['before'=>['auth','admin'], 'uses' => 'ExpenseController@getDeleteExpense', 'as' => 'admin-getdeleteexpense']);
Route::post('/admin/expenses/{expense}/delete', ['before'=>['auth','admin'], 'uses' => 'ExpenseController@postDeleteExpense', 'as' => 'admin-postdeleteexpense']);

Route::get('/admin/pointsale/{sale}/delete', ['before'=>['auth','admin'], 'uses' => 'AdminController@getDeletePointsale', 'as' => 'admin-getdeletesale']);
Route::post('/admin/pointsale/{sale}/delete', ['before'=>['auth','admin'], 'uses' => 'AdminController@postDeletePointsale', 'as' => 'admin-postdeletesale']);

//Route::get('/manualevents/generate-orders', array('before' => 'auth', 'uses' => 'ManualEventsController@OrderGeneration'));

//stuff everything needs
View::composer('*', function($view) {
	$view->with('dates', BaseController::getFormattedDates());
});

//no throttle
$throttleProvider = Sentry::getThrottleProvider()->disable();
