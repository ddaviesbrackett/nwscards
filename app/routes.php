<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function(){
	return Response::json(Input::all());
});

Route::get('/new', function(){
	return View::make('new');
});

Route::post('/new', array('before' => 'csrf', function()
{
 	$rules = array(
			'name'		=> 'required',
			'email'		=> 'required|email|unique:users',
			'phone'		=> 'required|digits:10',
			'password'	=> 'required',
			'address1'	=> 'required',
			'city'		=> 'required',
			'postal_code'	=> 'required|regex:/^\w\d\w ?\d\w\d$/',
			'schedule'	=> 'required|in:biweekly,4weekly',
			'saveon'	=> 'digits_between:1,2|required_without:coop',
			'coop'		=> 'digits_between:1,2|required_without:saveon',
			'payment'	=> 'required|in:debit,credit',
		);
  	$in = Input::all();
  	//store phone as a number, but allow people to type ( and ) and - and space in it
  	$in['phone'] = preg_replace('/[- \\(\\)]*/','',$in['phone']);

	$validator = Validator::make($in, $rules);

	// process the login
	if ($validator->fails()) {
		return Redirect::to('/new')
			->withErrors($validator)
			->withInput(Input::except('password'));
	} else {
		Sentry::register(array(
			'email'		=>$in['email'],
			'password'	=>$in['password'],
			'name'		=>$in['name'],
			'phone'		=>$in['phone'],
			'address1'	=>$in['address1'],
			'address2'	=>$in['address2'],
			'city'		=>$in['city'],
			'province'	=>'BC',
			'postal_code'	=>$in['postal_code'],
			'marigold' => array_key_exists('marigold', $in),
			'daisy' => array_key_exists('daisy', $in),
			'sunflower' => array_key_exists('sunflower', $in),
			'bluebell' => array_key_exists('bluebell', $in),
			'class_1' => array_key_exists('class_1', $in),
			'class_2' => array_key_exists('class_2', $in),
			'class_3' => array_key_exists('class_3', $in),
			'class_4' => array_key_exists('class_4', $in),
			'class_5' => array_key_exists('class_5', $in),
			'class_6' => array_key_exists('class_6', $in),
			'class_7' => array_key_exists('class_7', $in),
			'class_8' => array_key_exists('class_8', $in),
		));

		// redirect
		Session::flash('message', 'Order created!');
		return Redirect::to('/');
	}
}));

