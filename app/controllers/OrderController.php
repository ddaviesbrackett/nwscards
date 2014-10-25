<?php

class OrderController extends BaseController {

	public function getAccount()
	{
		$user = Sentry::getUser();
		$user->load('orders');
		return View::make('account', [
			'user' => $user,
			'message' => Session::get('ordermessage'),
			'mostRecentOrder' => $user->orders()->first(),
			]);
	}

	public function postAccount()
	{
		return View::make('account');
	}

	public function getNew()
	{
		return View::make('new', ['stripeKey' => $_ENV['stripe_pub_key'], 'user'=> null]);
	}

	public function getEdit()
	{
		if(OrderController::IsBlackoutPeriod())
		{
			return View::make('edit-blackout');
		}
		else
		{
			return View::make('new', ['stripeKey' => $_ENV['stripe_pub_key'], 'user'=> Sentry::getUser()]);
		}
	}

	public function postEdit()
	{
		if(OrderController::IsBlackoutPeriod())
		{
			return View::make('edit-blackout');
		}

		$user = Sentry::getUser();
		
		if (Input::has('password'))
		{
			$in = Input::all();
		}
		else
		{
			$in = Input::except(array('password', 'password-repeat'));
	  	}

	  	$in['phone'] = preg_replace('/[- \\(\\)]*/','',$in['phone']);

 		$validator = Validator::make($in, OrderController::GetRules($user->id), OrderController::GetMessages());
		
		// process the login
		if ($validator->fails()) {
			return Redirect::to('/edit')
				->withErrors($validator)
				->withInput(Input::all());
		} else {
			$user->email = $in['email'];
			$user->name = $in['name'];
			$user->phone = $in['phone'];
			$user->address1 = $in['address1'];
			$user->address2 = $in['address2'];
			$user->city = $in['city'];
			$user->postal_code = $in['postal_code'];
			$user->marigold = array_key_exists('marigold', $in);
			$user->daisy = array_key_exists('daisy', $in);
			$user->sunflower = array_key_exists('sunflower', $in);
			$user->bluebell = array_key_exists('bluebell', $in);
			$user->class_1 = array_key_exists('class_1', $in);
			$user->class_2 = array_key_exists('class_2', $in);
			$user->class_3 = array_key_exists('class_3', $in);
			$user->class_4 = array_key_exists('class_4', $in);
			$user->class_5 = array_key_exists('class_5', $in);
			$user->class_6 = array_key_exists('class_6', $in);
			$user->class_7 = array_key_exists('class_7', $in);
			$user->class_8 = array_key_exists('class_8', $in);

			if (Input::has('password'))
			{
				$user->password = $in['password'];
			}

			$cardToken = ( ($in['payment'] == 'credit') && isset($in['stripeToken']) ) ? $in['stripeToken'] : null;

			$bIsSubscribed = $user->onPlan('28days') || $user->onPlan('14days');
			
			// if they are paying with credit already, let them change the card.
			if ( ( $cardToken != null ) && ( $user->payment == 1 ) && ( $bIsSubscribed ) )
			{
				$user->subscription()->updateCard($cardToken);
				$cardToken = null;
			}

			if ( !(OrderController::IsBlackoutPeriod()) )
			{
				$user->deliverymethod = $in['deliverymethod'] == 'mail';
				$user->referrer = $in['referrer'];
				$user->pickupalt = $in['pickupalt'];
				$user->employee = array_key_exists('employee', $in);

				$bStripePlanChanged = ( ($user->saveon != $in['saveon']) || ($user->coop != $in['coop']) || ($user->schedule != $in['schedule']) );
		
				$user->saveon = $in['saveon'];
				$user->coop = $in['coop'];
				$user->schedule = $in['schedule'];
				
				$plan = null;
				if($in['schedule'] == 'biweekly')
				{
					$plan = '14days';
				}
				else 
				{
					$plan = '28days';
				}
			
				$stripeUser = $user->subscription()->getStripeCustomer();
				$stripeUser->email = $user->email;
				$stripeUser->description = $user->name;
				
				if( $in['payment'] == 'debit' )
				{
					//TODO donna will need to know about this?
					$user->payment = 0;
					$user->stripe_active = 1;
					$extras = [
						'debit-transit'=>$in['debit-transit'],
						'debit-institution'=>$in['debit-institution'],
						'debit-account'=>$in['debit-account'],
					];
					$stripeUser->metadata = $extras;
					
					if ($bIsSubscribed)
					{
						$user->subscription()->cancelNow();
						$bIsSubscribed = false;
					}

				}
			
				$stripeUser->save();
			
				if( $in['payment'] == 'cancel')
				{
					// if they cancel, remove their plan in stripe (if they have one)
					// TODO: fix this so we can cancel/resume 
					if ( $bIsSubscribed )
					{
						// cancel immediately.
						$user->subscription()->cancelNow();
					}
					$user->stripe_active = 0;
				}
				else if ( ($in['payment'] == 'resume') && ($user->payment == 0) )
				{ // resume a debit plan
					$user->stripe_active = 1;
				}
				else if ( (( $cardToken != null ) && !( $bIsSubscribed )) // credit card selected -> new stripe subscription
				  || ( $bIsSubscribed && $bStripePlanChanged ) // changing stripe subscription
				  || ($user->stripe_active == 0 && $user->payment == 1 && $in['payment'] == 'resume') ) // resume stripe subscription
				{
					$user->stripe_active = 1;
					$user->payment = 1;

					$gateway = null;

					// to avoid prorating, just cancel and recreate plan.
					if ($bIsSubscribed)
					{
						$user->subscription()->cancelNow();
					}

					//subscribing to a new plan.
					$chargedate = BaseController::getCutoffs()[$in['schedule']]['charge'];
					$gateway = $user->subscription($plan)->trialFor($chargedate)->quantity($in['saveon']+$in['coop']);
					$gateway->create($cardToken, array(), $gateway->getStripeCustomer());
				}
			}
				
			if ($user->save())
			{
				Mail::send('emails.newconfirmation', ['user' => $user, 'isChange' => true], function($message) use ($user){
					$message->subject('Grocery card order change confirmation');
					$message->to($user->email, $user->name);
					if(! $user->payment)
					{
						$agreementView = View::make('partial.debitterms');
						$agreement = '<html><body>'.$agreementView->render().'</body></html>';
						$message->attachData($agreement, 'debit-agreement.html', ['mime'=>'text/html', 'as'=>'debit-agreement.html']);
					}
				});
				return Redirect::to('/account');	
			}
			else
			{
				//what went wrong??
			}
		}
	}

	public function postNew()
	{

	  	$in = Input::all();
	  	$in['phone'] = preg_replace('/[- \\(\\)]*/','',$in['phone']);

 		$validator = Validator::make($in, OrderController::GetRules(), OrderController::GetMessages());

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
				'schedule' => $in['schedule'],
				'deliverymethod' => $in['deliverymethod'] == 'mail',
				'referrer' => $in['referrer'],
				'pickupalt' => $in['pickupalt'],
			], true);
			try {
				$plan = null;
				if($in['schedule'] == 'biweekly'){
					$plan = '14days';
				}
				else {
 					$plan = '28days';
				}
				$cardToken = null;
				if(isset($in['stripeToken'])){
					$cardToken = $in['stripeToken'];
				}
				$gateway = null;
				if(isset($cardToken)) {
						$chargedate = BaseController::getCutoffs()[$in['schedule']]['charge'];
						$gateway = $user->subscription($plan)->trialFor($chargedate)->quantity($in['saveon']+$in['coop']);
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
			}
			catch(\Exception $e) {
				$user->delete();
				throw $e;
			}

			Mail::send('emails.newconfirmation', ['user' => $user, 'isChange' => false], function($message) use ($user){
				$message->subject('Grocery card order confirmation');
				$message->to($user->email, $user->name);
				if(! $user->payment)
				{
					$agreementView = View::make('partial.debitterms');
					$agreement = '<html><body>'.$agreementView->render().'</body></html>';
					$message->attachData($agreement, 'debit-agreement.html', ['mime'=>'text/html', 'as'=>'debit-agreement.html']);
				}
			});
			// redirect
			Session::flash('ordermessage', 'order created');
			Sentry::login($user, false);
			return Redirect::to('/account');			
		}
	}

	public static function GetBlackoutEndDate()
	{
		return BaseController::getCutoffs()['biweekly']['cutoff']->addDays(-7);
	}

	// Blackout period is from cutoff wednesday at midnight until card pickup wednesday morning.
	public static function IsBlackoutPeriod()
	{	
		return false && ((new \Carbon\Carbon('America/Los_Angeles')) < OrderController::GetBlackoutEndDate());
	}

	private static function GetRules($id=null)
	{
		return [
				'name'		=> 'required',
				'email'		=> 'required|email|unique:users,email' . ($id != null ? ",$id" : ""),
				'phone'		=> 'digits:10',
				'password'	=> 'sometimes:required',
				'password-repeat'	=> 'sometimes:required|same:password',
				'address1'	=> 'required_if:deliveyrmethod,mail',
				'city'		=> 'required_if:deliverymethod,mail',
				'postal_code'	=> 'required_if:deliverymethod,mail|regex:/^\w\d\w ?\d\w\d$/',
				'schedule'	=> 'required|in:biweekly,monthly,monthly-second',
				'saveon'	=> 'digits_between:1,2|required_without:coop',
				'coop'		=> 'digits_between:1,2|required_without:saveon',
				'payment'	=> 'required|in:debit,credit,keep,cancel,resume',
				'debit-transit'		=> 'required_if:payment,debit|digits:5',
				'debit-institution'	=> 'required_if:payment,debit|digits:3',
				'debit-account' 	=> 'required_if:payment,debit|digits_between:5,15',
				'debitterms' 	=> 'required_if:payment,debit',
				'mailwaiver'	=>'required_if:deliverymethod,mail',
				'deliverymethod' => 'required',
			];
	}

	private static function GetMessages()
	{
	 	return [
	 			'debit-transit.required_if' => 'branch number is required.',
	 			'debit-institution.required_if' => 'institution is required.',
	 			'debit-account.required_if' => 'account number is required.',
	 			'debitterms.required_if' => 'You must agree to the terms to pay by pre-authorized debit.',
	 		];
	}

}
