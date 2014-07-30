<?php

class HomeController extends BaseController {
	public function getHome()
	{
		return View::make('home');
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
		    echo 'Login failed.';
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
		    echo 'Login failed.';
		}
		catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
		{
		    echo 'Login failed.';
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    echo 'Login failed.';
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
		    echo 'Login failed.';
		}
		if(! empty($error))
		{
			return View::make('home');
		}
		else
		{
			return Redirect::to(Session::pull('url.intended', '/account'));
		}
	}
}