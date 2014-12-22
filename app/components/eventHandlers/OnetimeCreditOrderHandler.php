<?php namespace NWSCards\components\eventHandlers;
use \CutoffDate;
use Stripe_Charge;
class OnetimeCreditOrderHandler {
	public function handle($date) {
		\Stripe::setApiKey($_ENV['stripe_secret_key']);
		$target = $date->copy()->subDays(5);
		$cutoff = CutoffDate::where('cutoff', '=', $target->format('Y-m-d'))->orderby('cutoff', 'desc')->first();
		if(! isset($cutoff)) {
			return;
		}

		foreach($cutoff->orders as $order)
		{
			$onetime = $order->saveon_onetime + $order->coop_onetime;
			if($order->isCreditcard() && ($order->saveon + $order->coop == 0) && $onetime != 0 )
			{
				Stripe_Charge::create([
					'customer' => $order->user->stripe_id,
					'amount' => $onetime * 100 * 100, //amount is in cents
					'currency' => 'cad',
					'description' => 'one-time grocery card order for '.$cutoff->deliverydate(),
					]);
			}
		}
		return "one-time CC orders charged for " . $date;
	}
}