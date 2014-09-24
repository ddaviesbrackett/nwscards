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

		return new NWSCardsStripeGateWay($this, $plan);
	}


	public function classesSupported() {
		$ret = [];
		if($this->marigold) $ret[] = 'marigold';
		if($this->daisy) $ret[] = 'daisy';
		if($this->sunflower) $ret[] = 'sunflower';
		if($this->bluebell) $ret[] = 'bluebell';
		if($this->class_1) $ret[] = 'class_1';
		if($this->class_2) $ret[] = 'class_2';
		if($this->class_3) $ret[] = 'class_3';
		if($this->class_4) $ret[] = 'class_4';
		if($this->class_5) $ret[] = 'class_5';
		if($this->class_6) $ret[] = 'class_6';
		if($this->class_7) $ret[] = 'class_7';
	 	if($this->class_8) $ret[] = 'class_8';

	 	return $ret;
	}

	public function orders() {
		return $this->hasMany('Order')->orderBy('created_at', 'desc');
	}

	public function cutoffdates() {
		return $this->belongsToMany('CutoffDate', 'orders');
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
		return $this->deliverymethod;
	}

	public static function className($class) {
		switch ($class) {
			case 'marigold': return 'Marigolds';
			case 'daisy': return 'Daisies';
			case 'sunflower': return 'Sunflowers';
			case 'bluebell': return 'Bluebells';
			case 'class_1': return 'Class 1';
			case 'class_2': return 'Class 2';
			case 'class_3': return 'Class 3';
			case 'class_4': return 'Class 4';
			case 'class_5': return 'Class 5';
			case 'class_6': return 'Class 6';
			case 'class_7': return 'Class 7';
			case 'class_8': return 'Class 8';
		}
	}

	/* apparently this tells Laravel what hasher should be used for changing passwords*/
	public static function boot()
    {
        self::$hasher = new \Cartalyst\Sentry\Hashing\NativeHasher;
    }

}
