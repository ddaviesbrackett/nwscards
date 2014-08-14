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

	public function getNew()
	{
		return View::make('new', array('delivery' => $this->formatCutoffs('P8D',$this->getCutoffs())));
	}

	public function postNew()
	{
	 	$rules = [
				'name'		=> 'required',
				'email'		=> 'required|email|unique:users',
				'phone'		=> 'required|digits:10',
				'password'	=> 'required',
				'password-repeat'	=> 'required|same:password',
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
			];

	 	$messages = [
	 			'debit-transit.required_if' => 'branch number is required.',
	 			'debit-institution.required_if' => 'institution is required.',
	 			'debit-account.required_if' => 'account number is required.',
	 		];
	  	//store phone as a number, but allow people to type ( and ) and - and space in it

	  	$in = Input::all();
	  	$in['phone'] = preg_replace('/[- \\(\\)]*/','',$in['phone']);

		$validator = Validator::make($in, $rules, $messages);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('/new')
				->withErrors($validator)
				->withInput(Input::all());
		} else {
			$user = Sentry::register([
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
				'saveon' => $in['saveon'],
				'coop' => $in['coop'],
				'payment' => $in['payment'] == 'credit',
			], true);

			$plan = null;
			if($in['schedule'] == 'biweekly'){
				$plan = '14days';
			}
			else if ($in['schedule'] == '4weekly') {
				$plan = '28days';
			}
			$cardToken = null;
			if(isset($in['stripeToken'])){
				$cardToken = $in['stripeToken'];
			}
			$gateway = null;
			if(isset($cardToken)) {
					$cutoffDate = new DateTime($this->getCutoffs()[$in['schedule']]);
					$cutoffDate->add(new DateInterval('P6D'));
					$gateway = $user->subscription($plan)->trialFor($cutoffDate)->quantity($in['saveon']+$in['coop']);
			}
			else {
				$gateway = $user->subscription(null); //just create them with no subs if they don't have a card
			}
			$extras = [
				'email' => $user->email, 
				'description' => $user->name,
			];
			if(!isset($cardToken))
			{
				$extras['metadata'] = [
					'debit-transit'=>$in['debit-transit'],
					'debit-institution'=>$in['debit-institution'],
					'debit-account'=>$in['debit-account'],
				];
			}
			$gateway->create($cardToken, $extras);
			// redirect
			Session::flash('message', 'Order created!');
			return Redirect::to('/');			
		}
	}

	private function formatCutoffs($interval, array $cutoffDates)
	{
		foreach($cutoffDates as $k => $v) {
			$date = new DateTime($v);
			$date->add(new DateInterval($interval));
			$cutoffDates[$k] = $date->format('l, F jS');
		}
		return $cutoffDates;
	}

	/*
	* cutoff dates are the last day on which we can accept an order; orders are charged 6 days later, and delivered 8 days later (so, 2 days after charge).
	*/
	private function getCutoffs( $target = NULL ) {;
		if(is_null($target)){
			$target = date('Y-m-d');
		}
		$ret = array();
		$cutoffs = DB::table('cutoffdates')->where('cutoff','>',$target)->orderBy('cutoff','asc')->take(2)->get();
		$cutoff = $cutoffs[0];
		$ret['biweekly'] = $cutoff->cutoff;
		if($cutoff->monthly) {
			$ret['4weekly'] = $cutoff->cutoff;
		}
		else
		{
			$ret['4weekly'] = $cutoffs[1]->cutoff;
		}
		return $ret;
	}
}
