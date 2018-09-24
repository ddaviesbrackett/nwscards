<?php
class HomeControllerTest extends BaseController {
	public function getHome()
	{
		$total = 0;
                $totalThisYear=0;

                
                /* this need to be fixed.  I also changed the home to remove the raised so far */
                
		foreach(SchoolClass::all() as $class)
		{
                         
                        $class_profit=DB::select('SELECT SUM(profit) as classTotal FROM classes_orders WHERE class_id='.$class->id.'');
                        $total+=$class_profit[0]->classTotal+ $class->pointsales->getTotalProfit(); 
                        //$classes_arr[$class->id]= $class_profit[0]->classTotal + $class->pointsales->getTotalProfit(); 

                        //getTotalProfit is not working and collapse the website. Need to re create it.
			//$total += $class->orders->getTotalProfit();
                        //$total += $class->pointsales->getTotalProfit(); 
                 
                        $ordersCollection=$class->orders()->where('updated_at','>','2017-09-01 00:00:00')->get();
                        $pointsaleCollection=$class->pointsales()->where('updated_at','>','2017-09-01 00:00:00')->get();
                        
                        $totalThisYear+=$ordersCollection->getTotalProfit();
                        $totalThisYear+=$pointsaleCollection->getTotalProfit();
                        
                        
		}
                 
		return View::make('homeTest', ['total'=>$total,'totalThisYear'=>$totalThisYear]);
	}

        /*
	public function generateOrders() {
            
                
		\Stripe::setApiKey($_ENV['stripe_secret_key']);
                 
                $target = Carbon\Carbon::now();
		$cutoff = \CutoffDate::where('cutoff', '=', $target->format('Y-m-d'))->orderby('cutoff', 'desc')->first();
                
		if(! isset($cutoff)) {
			return;
		}
               
		$currentMonthly = $cutoff->first?'monthly':'monthly-second';

		if($cutoff->orders->isEmpty()){ //don't regenerate orders that have been generated already
			$users = User::where('stripe_active', '=', 1)
			->where(function($q){ // shoudn't need this - UI enforces not both 0 order columns
				$q->where('saveon', '>', '0')
				  ->orWhere('coop','>','0')
				  ->orWhere('saveon_onetime', '>', '0')
				  ->orWhere('coop_onetime','>','0');
			})
			->where(function($q) use ($currentMonthly){
				$q->where('schedule', '=', 'biweekly')
				  ->orWhere('schedule', '=', $currentMonthly)
				  ->orWhere('schedule_onetime', '=', $currentMonthly);
                                
			})
                        ->get(); 

                        
			foreach($users as $user) {
				$order = new Order([
					'paid' => 0,
					'payment' => $user->payment,
					'deliverymethod' => $user->deliverymethod,
					]);
                                if($user->schedule == 'biweekly' || $user->schedule == $currentMonthly)	{
					$order->coop = $user->coop;
					$order->saveon = $user->saveon;
				}
				if($user->schedule_onetime == $currentMonthly ) {
					$order->coop_onetime = $user->coop_onetime;
					$order->saveon_onetime = $user->saveon_onetime;
					$user->coop_onetime = 0;
					$user->saveon_onetime = 0;
					$user->schedule_onetime = 'none';
					$user->save();
				}
				$order->cutoffdate()->associate($cutoff);
				$user->orders()->save($order);
				$order->schoolclasses()->sync($user->schoolclasses);

				//since we're now entering the blackout period, we can add one-time orders to credit card invoices
				//orders that are onetime-ONLY get dealt with separately on charge day, because this is easier than sorting through Stripe's API docs
				if($order->isCreditcard() && ($order->saveon + $order->coop > 0) && ($order->saveon_onetime + $order->coop_onetime > 0) ) {
					Stripe_InvoiceItem::create([
						'customer' => $user->stripe_id, 
						'currency' => 'cad', 
						'description' => 'one-time order',
						'amount' => ($order->saveon_onetime + $order->coop_onetime) * 100 * 100,
					]);
				}

				Mail::send('emails.chargereminder', ['user' => $user, 'order' => $order], function($message) use ($user, $order){
					$message->subject('Grocery cards next week - you\'ll be charged Monday');
					$message->to($user->email, $user->name);
				});* 
			}
			return "orders generated for " . $date;
                         
		}
		//return "orders already generated for this date";
                return View::make('homeTest', ['total'=>'0','totalThisYear'=>'0']);
	}
        */
        
	public function getLogin() {
		return View::make('login')->with('error', '');
	}

	public function postLogin()
	{
		$credentials = Input::only('email', 'password');
		$error = '';
		try
		{
		    $user = Sentry::authenticate($credentials, false);
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
		    $error ='Login failed.';
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
		    $error ='Login failed.';
		}
		catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
		{
		    $error ='Login failed.';
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    $error ='Login failed.';
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
		    $error ='Login failed.';
		}
		if(! empty($error))
		{
			return View::make('login')->with('error', $error);
		}
		else
		{
			return Redirect::to(Session::pull('url.intended', '/account'));
		}
	}

	public function getLogout()	{
		Sentry::logout();
		return Redirect::to('/');
	}

	public function postContact() {
		$status = 'failure';
		$email = Input::get('em', '(not provided)');
		$name = Input::get('nm', '(not provided)');
		$data = Input::only('msg', 'nm', 'em');
		Mail::send('emails.contact', $data, function($message) use ($email, $name){
			$message->subject('Home Page contact request');
			$message->to('grocerycards@nelsonwaldorf.org', 'Nelson Waldorf School Grocery Cards');
			$message->from($email, $name);
		});
		$status = 'success';
		return Response::json(['r' =>['status' => $status]]);
	}
}