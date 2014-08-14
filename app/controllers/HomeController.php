<?php

class HomeController extends BaseController {
	public function getHome()
	{
		return View::make('home', array('total'=>'$674')); //TODO pull the total from the DB order aggregates
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
}