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

	/**
	 * Get a new billing gateway instance for the given plan. Overridden to avoid a Laravel Cashier bug with stripe customers who don't have cards.
	 *
	 * @param  \Laravel\Cashier\PlanInterface|string|null  $plan
	 * @return \Laravel\Cashier\StripeGateway
	 */
	public function subscription($plan = null)
	{
		if ($plan instanceof PlanInterface) $plan = $plan->getStripeId();

		return new \NWSCards\components\overrides\StripeGateway($this, $plan);
	}

	public function orders() {
		return $this->hasMany('Order')->orderBy('created_at', 'desc');
	}

	public function cutoffdates() {
		return $this->belongsToMany('CutoffDate', 'orders');
	}

	public function schoolclasses() {
		return $this->belongsToMany('SchoolClass', 'classes_users', 'user_id', 'class_id')->orderBy('displayorder');
	}

	public function isAdmin() {
		$groups = $this->getGroups();
		$isAdmin = false;
		foreach ($groups as $group) {
			if($group->name == 'Administrator') {
				$isAdmin = true;
				break;
			}
		}
		return $isAdmin;
	}

	public function address() {
		return implode(' ', [$this->address1, $this->address2, $this->city, $this->province, $this->postal_code]);
	}

	public function getPhone() {
		return sprintf('(%s) %s-%s', substr($this->phone, 0, 3),substr($this->phone, 3, 3), substr($this->phone, 6)) ;
	}

	public function isMail() {
		return $this->deliverymethod == 1;
	}

	public function isCreditcard() {
		return $this->payment == 1;
	}

	public function getFriendlySchedule() {
		switch ($this->schedule) {
			case 'biweekly':
				return 'Bi-weekly';
			case 'monthly':
				return 'Monthly';
			case 'monthly-second':
				return 'Monthly';
			case 'none':
				return 'Never';
			default:
				throw new Exception("Invalid schedule");
				break;
		}
	}

	/* apparently this tells Laravel what hasher should be used for changing passwords*/
	public static function boot()
    {
        self::$hasher = new \Cartalyst\Sentry\Hashing\NativeHasher;
    }

}
