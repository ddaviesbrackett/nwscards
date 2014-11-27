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

	public function Suspend()
	{
		if(OrderController::IsBlackoutPeriod())
		{
			return View::make('edit-blackout');
		}

		$user = Sentry::getUser();

		if ($user->hasStripePlan())
		{
			$user->subscription()->cancelNow();
		}
		//suspending while you're already suspended shouldn't clobber your saved schedule
		$user->schedule_suspended = $user->schedule == 'none' ? $user->schedule_suspended : $user->schedule;
		$user->schedule = 'none';
		$user->save();
		Mail::send('emails.suspend', ['user' => $user, 'isChange' => true], function($message) use ($user){
			$message->subject('Grocery card order suspended');
			$message->to($user->email, $user->name);
		});
		Session::flash('ordermessage', 'order suspended');
		return Redirect::to('/account');	
	}

	public function Resume()
	{
		if(OrderController::IsBlackoutPeriod())
		{
			return View::make('edit-blackout');
		}

		$user = Sentry::getUser();
		if($user->schedule_suspended != 'none') {
			$user->schedule = $user->schedule_suspended;
			
			if ( $user->isCreditCard() )
			{
				$plan = null;
				if($user->schedule == 'biweekly'){
					$plan = '14days';
				}
				else {
					$plan = '28days';
				}
				$chargedate = BaseController::getCutoffs()[$user->schedule]['charge'];
				$gateway = $user->subscription($plan)->trialFor($chargedate)->quantity($user->saveon + $user->coop);
				$gateway->create(null, array(), $gateway->getStripeCustomer());
			}
			$user->save();
			Mail::send('emails.newconfirmation', ['user' => $user, 'isChange' => true], function($message) use ($user){
				$message->subject('Grocery card order resumed');
				$message->to($user->email, $user->name);
				if(! $user->isCreditCard())
				{
					$agreementView = View::make('partial.debitterms');
					$agreement = '<html><body>'.$agreementView->render().'</body></html>';
					$message->attachData($agreement, 'debit-agreement.html', ['mime'=>'text/html', 'as'=>'debit-agreement.html']);
				}
			});
			Session::flash('ordermessage', 'order resumed');
			return Redirect::to('/account');
		}
		else {
			throw new Exception("Error Processing Request: no schedule to resume", 500);
			
		}
	}
	public function getOnetime() {
		if(OrderController::IsBlackoutPeriod())
		{
			return View::make('edit-blackout');
		}
		return View::make('account-onetimeform', ['user'=>Sentry::getUser()]);
	}

	public function postOnetime() {
		if(OrderController::IsBlackoutPeriod())
		{
			return View::make('edit-blackout');
		}

		$user = Sentry::getUser();
		$s_o = Input::get('saveon_onetime');
		$c_o = Input::get('coop_onetime');
		if(filter_var($s_o, FILTER_VALIDATE_INT) !== false && 
			filter_var($c_o, FILTER_VALIDATE_INT) !== false	&& 
			$s_o >= 0 && 
			$c_o >= 0) {
			$user->saveon_onetime = $s_o;
			$user->coop_onetime = $c_o;
			$sched = $user->schedule;
			if($sched = 'biweekly') {
				$cutoffs = $this->getCutoffs();
				$sched = $cutoffs['biweekly']['cutoff'] == $cutoffs['monthly']['cutoff'] ? 'monthly' : 'monthly-second';
			}
			$user->schedule_onetime = $sched;
			$user->save();
			Session::flash('ordermessage', 'order updated');
		}
		return Redirect::to('/account');
	}

	public function getNew()
	{
		$visibleorder = Session::getOldInput('visibleorder', 'recurring');
		return View::make('new', ['stripeKey' => $_ENV['stripe_pub_key'], 'user'=> null, 'visibleorder'=> $visibleorder]);
	}

	public function getEdit()
	{
		if(OrderController::IsBlackoutPeriod())
		{
			return View::make('edit-blackout');
		}
		else
		{
			$visibleorder = Session::getOldInput('visibleorder', 'recurring');
			return View::make('new', ['stripeKey' => $_ENV['stripe_pub_key'], 'user'=> Sentry::getUser(), 'visibleorder'=> $visibleorder]);
		}
	}

	public function postEdit()
	{
		if(OrderController::IsBlackoutPeriod())
		{
			return View::make('edit-blackout');
		}

		$user = Sentry::getUser();
		
		$in = Input::all();

	  	$in['phone'] = preg_replace('/[- \\(\\)]*/','',$in['phone']);

 		$validator = OrderController::GetValidator($in);
		$validator->mergeRules('email', 'unique:users,email,' . $user->id);

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

			$bIsSubscribed = $user->hasStripePlan();
			
			// if they are paying with credit already, let them change the card.
			if ( ( $cardToken != null ) && ( $user->isCreditcard() ) && ( $bIsSubscribed ) )
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

				$user->saveon_onetime = $in['saveon_onetime'];
				$user->coop_onetime = $in['coop_onetime'];
				$user->schedule_onetime = $in['schedule_onetime'];

				$bStripePlanChanged = ( ($user->saveon != $in['saveon']) || ($user->coop != $in['coop']) || ($user->schedule != $in['schedule']) );
		
				$user->saveon = $in['saveon'];
				$user->coop = $in['coop'];
				
				$plan = null;
				if($in['schedule'] == 'biweekly')
				{
					$plan = '14days';
				}
				else if($in['schedule'] == 'monthly' || $in['schedule'] == 'monthly-second')
				{
					$plan = '28days';
				}
				else //schedule is none - save old schedule for resume, cancel credit card
				{
					$user->schedule_suspended = $user->schedule == 'none' ? $user->schedule_suspended : $user->schedule;
					if ($bIsSubscribed)
					{
						$user->subscription()->cancelNow();
						$bIsSubscribed = false;
					}
				}

				$user->schedule = $in['schedule'];
			
				$stripeUser = $user->subscription()->getStripeCustomer();
				$stripeUser->email = $user->email;
				$stripeUser->description = $user->name;
				
				if( $in['payment'] == 'debit' )
				{
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

					$user->payment = 0;

					// cancelling plan sets stripe-active to 0. need to reset it here.
					$user->stripe_active = 1;
				}
			
				$stripeUser->save();
			
				 if ( $plan != null && 
				 		( ( !$bIsSubscribed && $cardToken != null ) // credit card selected -> new stripe subscription
					  	 || ( $bIsSubscribed && $bStripePlanChanged ) ) // changing stripe subscription
					) 
				{
					$user->payment = 1;

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
					if(! $user->isCreditCard())
					{
						$agreementView = View::make('partial.debitterms');
						$agreement = '<html><body>'.$agreementView->render().'</body></html>';
						$message->attachData($agreement, 'debit-agreement.html', ['mime'=>'text/html', 'as'=>'debit-agreement.html']);
					}
				});
				Session::flash('ordermessage', 'order updated');
				return Redirect::to('/account');	
			}
			else
			{
				throw new Exception("Error Processing Request: user save failed", 501);
				
			}
		}
	}

	public function postNew()
	{

	  	$in = Input::all();
	  	$in['phone'] = preg_replace('/[- \\(\\)]*/','',$in['phone']);

 		$validator = OrderController::GetValidator($in);
 		
 		$validator->mergeRules('password', 'required');
 		$validator->mergeRules('email', 'unique:users,email');

 		$validator->sometimes('schedule', 'in:biweekly,monthly,monthly-second', function($input) {
			return $input->schedule_onetime == 'none';
		});
		$validator->sometimes('schedule_onetime', 'in:monthly,monthly-second', function($input) {
			return $input->schedule == 'none';
		});
		$validator->setCustomMessages([
				'schedule.in'=> 'We need either a recurring order or a one-time order.',
				'schedule_onetime.in'=> 'We need either a recurring order or a one-time order.',
				]);

		// process the new user
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
				'schedule' => $in['schedule'],
				'saveon_onetime' => $in['saveon_onetime'],
				'coop_onetime' => $in['coop_onetime'],
				'schedule_onetime' => $in['schedule_onetime'],
				'payment' => $in['payment'] == 'credit',
				'deliverymethod' => $in['deliverymethod'] == 'mail',
				'referrer' => $in['referrer'],
				'pickupalt' => $in['pickupalt'],
			], true);
			try {
				$plan = null;
				if($in['schedule'] == 'biweekly'){
					$plan = '14days';
				}
				else if($in['schedule'] == 'monthly' || $in['schedule'] == 'monthly-second'){
 					$plan = '28days';
				}
				$cardToken = null;
				if(isset($in['stripeToken'])){
					$cardToken = $in['stripeToken'];
				}
				$gateway = null;
				if(isset($cardToken) && $in['saveon']+$in['coop'] > 0) {
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

	// Blackout period is from cutoff wednesday just before midnight until card pickup wednesday morning.
	public static function IsBlackoutPeriod()
	{
		return false && ((new \Carbon\Carbon('America/Los_Angeles')) < OrderController::GetBlackoutEndDate());
	}

	private static function GetValidator( $in ) {
		$v = Validator::make($in, [
				'name'		=> 'required',
				'email'		=> 'required|email',
				'phone'		=> 'digits:10',
				'password-repeat'	=> 'same:password',
				'address1'	=> 'required_if:deliveyrmethod,mail',
				'city'		=> 'required_if:deliverymethod,mail',
				'postal_code'	=> 'required_if:deliverymethod,mail|regex:/^\w\d\w ?\d\w\d$/',
				'schedule'	=> 'in:none,biweekly,monthly,monthly-second',
				'schedule_onetime'	=> 'in:none,monthly,monthly-second',
				'saveon'	=> 'integer|digits_between:1,2',
				'coop'		=> 'integer|digits_between:1,2',
				'saveon_onetime'	=> 'integer|digits_between:1,2',
				'coop_onetime'		=> 'integer|digits_between:1,2',
				'payment'	=> 'required|in:debit,credit,keep',
				'debit-transit'		=> 'required_if:payment,debit|digits:5',
				'debit-institution'	=> 'required_if:payment,debit|digits:3',
				'debit-account' 	=> 'required_if:payment,debit|digits_between:5,15',
				'debitterms' 	=> 'required_if:payment,debit',
				'mailwaiver'	=>'required_if:deliverymethod,mail',
				'deliverymethod' => 'required',
			], [
				'debit-transit.required_if' => 'branch number is required.',
				'debit-institution.required_if' => 'institution is required.',
				'debit-account.required_if' => 'account number is required.',
				'debitterms.required_if' => 'You must agree to the terms to pay by pre-authorized debit.',
				'saveon.required' => 'You need to order at least one card.',
				'coop.required' => 'You need to order at least one card.',
				'saveon_onetime.required' => 'You need to order at least one card.',
				'coop_onetime.required' => 'You need to order at least one card.',
				'saveon.min' => 'You need to order at least one card.',
				'coop.min' => 'You need to order at least one card.',
				'saveon_onetime.min' => 'You need to order at least one card.',
				'coop_onetime.min' => 'You need to order at least one card.',
				'schedule.not_in' => 'Choose a delivery date',
				'schedule_onetime.not_in' => 'Choose a delivery date',
			]);
		$v->sometimes('schedule', 'not_in:none', function($input){
			return $input['saveon'] > 0 ||
				   $input['coop'] > 0;
		});
		$v->sometimes('schedule_onetime', 'not_in:none', function($input){
			return $input['saveon_onetime'] > 0 ||
				   $input['coop_onetime'] > 0;
		});

		//rules for order amounts are complicated.  They can't both be 0 if they have a schedule
		$orderRequired = function($schedulefield, $field, $other) use ($v, $in) {
			if (($in[$schedulefield] == 'biweekly' ||
					   $in[$schedulefield] == 'monthly' ||
					   $in[$schedulefield] == 'monthly-second') 
					&& 
					   ($in[$other] == '' || $in[$other] == '0') ){
					   		$v->mergeRules($field, 'required|min:1');
					   }
			else {
				$v->mergeRules($field, 'min:0');
			}
		};
		
		$orderRequired('schedule', 'saveon', 'coop');
		$orderRequired('schedule', 'coop', 'saveon');
		$orderRequired('schedule_onetime', 'saveon_onetime', 'coop_onetime');
		$orderRequired('schedule_onetime', 'coop_onetime', 'saveon_onetime');

		return $v;
	}

	

}
