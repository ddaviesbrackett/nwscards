<?php namespace NWSCards\eventHandlers;
use \CutoffDate;
use User;
use Order;
use Mail;
use Stripe_InvoiceItem;
class OrderGenerationHandler {
	public function handle($date) {
		\Stripe::setApiKey($_ENV['stripe_secret_key']);
		$target = $date->copy();
		$cutoff = \CutoffDate::where('cutoff', '=', $target->format('Y-m-d'))->orderby('cutoff', 'desc')->first();
		if(! isset($cutoff)) {
			return;
		}
		$currentMonthly = $cutoff->first?'monthly':'monthly-second';

		if($cutoff->orders->isEmpty()){ //don't regenerate orders that have been generated already
			$users = User::where('stripe_active', '=', 1)
			->where(function($q){ // shoudn't need this - UI enforces not both 0 order columns
				$q->where('saveon', '>', '0')
				  ->orWhere('coop','>','0')
				  ->orWhere('saveon_onetime', '>', '0')
				  ->orWhere('coop_onetime','>','0');
			})
			->where(function($q) use ($currentMonthly){
				$q->where('schedule', '=', 'biweekly')
				  ->orWhere('schedule', '=', $currentMonthly)
				  ->orWhere('schedule_onetime', '=', $currentMonthly);
			})
			->get();

			foreach($users as $user) {
				$order = new Order([
					'paid' => 0,
					'payment' => $user->payment,
					'deliverymethod' => $user->deliverymethod,
					]);
				if($user->schedule == 'biweekly' || $user->schedule == $currentMonthly)	{
					$order->coop = $user->coop;
					$order->saveon = $user->saveon;
				}
				if($user->schedule_onetime == $currentMonthly ) {
					$order->coop_onetime = $user->coop_onetime;
					$order->saveon_onetime = $user->saveon_onetime;
					$user->coop_onetime = 0;
					$user->saveon_onetime = 0;
					$user->schedule_onetime = 'none';
					$user->save();
				}
				$order->cutoffdate()->associate($cutoff);
				$user->orders()->save($order);

				//since we're now entering the blackout period, we can add one-time orders to credit card invoices
				//orders that are onetime-ONLY get dealt with separately on charge day, because this is easier than sorting through Stripe's API docs
				if($order->isCreditcard() && ($order->saveon + $order->coop > 0) && ($order->saveon_onetime + $order->coop_onetime > 0) ) {
					Stripe_InvoiceItem::create([
						'customer' => $user->stripe_id, 
						'currency' => 'cad', 
						'description' => 'one-time order',
						'amount' => ($order->saveon_onetime + $order->coop_onetime) * 100 * 100,
					]);
				}

				Mail::send('emails.chargereminder', ['user' => $user, 'order' => $order], function($message) use ($user, $order){
					$message->subject('Grocery cards next week - you\'ll be charged Monday');
					$message->to($user->email, $user->name);
				});
			}
			return "orders generated for " . $date;
		}
		return "orders already generated for this date";
	}
}