<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Laravel\Cashier\BillableTrait;
use Laravel\Cashier\BillableInterface;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUser;

class User extends SentryUser implements UserInterface, RemindableInterface, BillableInterface {

	use UserTrait, RemindableTrait, BillableTrait;

	//billable dates
	protected $dates = ['trial_ends_at', 'subscription_ends_at'];

	public function getCurrency()
	{
		return 'cad';
	}

	/**
	 * Get the locale for the currency used by the entity.
	 *
	 * @return string
	 */
	public function getCurrencyLocale()
	{
		return 'en_CA';
	}

}
