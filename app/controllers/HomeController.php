<?php

class HomeController extends BaseController {
	public function getHome()
	{
		return View::make('home', array('total'=>'$1380.20')); //TODO pull the total from the DB order aggregates
	}


	public function getLogin() {
		return View::make('login');
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
			return View::make('login');
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