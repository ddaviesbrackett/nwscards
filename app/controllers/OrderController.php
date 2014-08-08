<?php

class OrderController extends BaseController {

	public function getAccount()
	{
		return View::make('account');
	}

	public function postAccount()
	{
		return View::make('account');
	}

	private function formatDelivery($row)
	{
		$date = new DateTime($row->cutoff);
		$date->add(new DateInterval('P8D'));
		return $date->format('l, F jS');
	}

	private function getDeliveries( $target) {;
		$ret = array();
		$cutoffs = DB::table('cutoffdates')->where('cutoff','>',$target)->orderBy('cutoff','asc')->take(2)->get();
		$cutoff = $cutoffs[0];
		$ret['biweekly'] = $this->formatDelivery($cutoff);
		if($cutoff->monthly) {
			$ret['monthly'] = $this->formatDelivery($cutoff);
		}
		else
		{
			$ret['monthly'] = $this->formatDelivery($cutoffs[1]);
		}
		return $ret;
	}

	public function getNew()
	{
		
		return View::make('new', array('delivery' => $this->getDeliveries(date('Y-m-d'))));
	}

	public function postNew()
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
				'debit-transit'		=> 'required_if:payment,debit|digits_between:5,7',
				'debit-institution'	=> 'required_if:payment,debit|digits:3',
				'debit-account' 	=> 'required_if:payment,debit|digits_between:5,15',
			);

	 	$messages = array(
	 			'debit-transit.required_if' => 'branch number is required.',
	 			'debit-institution.required_if' => 'institution is required.',
	 			'debit-account.required_if' => 'account number is required.',
	 		);

	  	$in = Input::all();
	  	//store phone as a number, but allow people to type ( and ) and - and space in it
	  	$in['phone'] = preg_replace('/[- \\(\\)]*/','',$in['phone']);

		$validator = Validator::make($in, $rules, $messages);

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
				//stripe_token => $in['stripeToken'],
			), true);

			// redirect
			Session::flash('message', 'Order created!');
			return Redirect::to('/');
		}
	}
}
