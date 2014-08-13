<?php

use Laravel\Cashier;

class NWSCardsStripeGateWay extends \Laravel\Cashier\StripeGateway {
	/**
	 * Get the last four credit card digits for a customer.
	 *
	 * @param  \Stripe_Customer  $customer
	 * @return string
	 */
	protected function getLastFourCardDigits($customer)
	{
		if(isset($customer_default_card))
		{
			return $customer->cards->retrieve($customer->default_card)->last4;
		}
		else
		{
			return null;
		}
	}
}