<?php

class HomeController extends BaseController {
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
                 

                        $ordersCollection=$class->orders()->where('updated_at','>','2021-09-01 00:00:00')->get();
                        $pointsaleCollection=$class->pointsales()->where('updated_at','>','2021-09-01 00:00:00')->get();
                        
                        $totalThisYear+=$ordersCollection->getTotalProfit();
                        $totalThisYear+=$pointsaleCollection->getTotalProfit();

                        
                        
		}

		return View::make('home', ['total'=>$total,'totalThisYear'=>$totalThisYear]);
	}


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
			$message->to('nwsgrocerycards@gmail.com', 'Nelson Waldorf School Grocery Cards');
			$message->from($email, $name);
		});
		$status = 'success';
		return Response::json(['r' =>['status' => $status]]);
	}
}