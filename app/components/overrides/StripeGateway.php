<?php
namespace NWSCards\components\overrides;
use Laravel\Cashier;

/*This class shouldn't have to exist.  But there are bugs in Cashier that this is going around.*/
class StripeGateWay extends Cashier\StripeGateway {
	/**
	 * Get the last four credit card digits for a customer.
	 *
	 * @param  \Stripe_Customer  $customer
	 * @return string
	 */
	protected function getLastFourCardDigits($customer)
	{
		if(isset($customer->default_card))
		{
			return $customer->cards->retrieve($customer->default_card)->last4;
		}
		else
		{
			$acct =  $customer->metadata['debit-account'];
			if(isset($acct)){
				return substr($acct, -4);
			}
			else {
				return null;
			}
		}
	}

	/**
	 * Subscribe to the plan for the first time.
	 *
	 * @param  string  $token
	 * @param  array   $properties
	 * @param  object|null  $customer
	 * @return void
	 */
	public function create($token, array $properties = array(), $customer = null)
	{
		$freshCustomer = false;

		if ( ! $customer)
		{
			$customer = $this->createStripeCustomer($token, $properties);

			$freshCustomer = true;
		}
		elseif ( ! is_null($token))
		{
			$this->updateCard($token);
		}
		
		if( ! is_null($this->plan)) {
			$this->billable->setStripeSubscription(
				$customer->updateSubscription($this->buildPayload())->id
			);
		}

		$customer = $this->getStripeCustomer($customer->id);

		if ($freshCustomer && $trialEnd = $this->getTrialEndForCustomer($customer))
		{
			$this->billable->setTrialEndDate($trialEnd);
		}

		$this->updateLocalStripeData($customer);
	}
}