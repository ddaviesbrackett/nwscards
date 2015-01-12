<?php namespace NWSCards\components\eventHandlers;
use \CutoffDate;
use Stripe_Charge;
use Stripe_CardError;
class CreditOrderHandler {
	public function handle($date) {
		\Stripe::setApiKey($_ENV['stripe_secret_key']);
		$target = $date->copy()->subDays(5);
		$cutoff = CutoffDate::where('cutoff', '=', $target->format('Y-m-d'))->orderby('cutoff', 'desc')->first();
		if(! isset($cutoff)) {
			return;
		}

		foreach($cutoff->orders as $order)
		{
			$cards = $order->saveon_onetime + $order->coop_onetime + $order->saveon + $order->coop;
			if($order->isCreditcard() && $cards != 0 && !$order->paid)
			{
				try
				{
					Stripe_Charge::create([
						'customer' => $order->user->stripe_id,
						'amount' => $cards * 100 * 100, //amount is in cents
						'currency' => 'cad',
						'description' => 'grocery card order for '.$cutoff->deliverydate(),
						]);
				}
				catch(Stripe_CardError $ex) 
				{

				}
				$order->paid = true;
				$order->save();
			}
		}
		return "CC orders charged for " . $date;
	}
}