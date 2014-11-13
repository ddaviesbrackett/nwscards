<?php namespace NWSCards\eventHandlers;
use \CutoffDate;
use Stripe_InvoiceItem, Stripe_Customer;
class OnetimeCreditOrderHandler {
	public function handle($date) {
		$target = $date->copy()->subDays(5);
		$cutoff = \CutoffDate::where('cutoff', '=', $target->format('Y-m-d'))->orderby('cutoff', 'desc')->first();
		if(! isset($cutoff)) {
			return;
		}

		foreach($cutoff->orders as $order)
		{
			$onetime = $order->saveon_onetime + $order->coop_onetime;
			if($order->isCreditcard() && ($order->saveon + $order->coop == 0) && $onetime != 0 )
			{
				Stripe_Charge::create([
					'customer' => $order->customer->stripe_id,
					'amount' => $onetime * 100 * 100, //amount is in cents
					'currency' => 'cad',
					'description' => 'one-time grocery card order for '.$cutoff->deliverydate(),
					]);
			}
		}
		return "one-time CC orders generated for " . $date;
	}
}