<?php namespace NWSCards\eventHandlers;
class OrderGenerationHandler {
	public function handle($date) {
		$target = $date->copy();
		$cutoff = \CutoffDate::where('cutoff', '=', $target->format('Y-m-d'))->orderby('cutoff', 'desc')->first();
		if(! isset($cutoff)) {
			return;
		}
		$currentMonthly = $cutoff->first?'monthly':'monthly-second';

		if($cutoff->orders->isEmpty()){ //don't regenerate orders that have been generated already
			$users = \User::where('stripe_active', '=', 1)
			->where(function($q){
				$q->where('saveon', '>', '0')->orWhere('coop','>','0');
			})
			->where(function($q) use ($currentMonthly){
				$q->where('schedule', '=', 'biweekly')->orWhere('schedule', '=', $currentMonthly);
			})
			->get();

			foreach($users as $user)
			{
				$order = new \Order([
					'paid' => 0,
					'payment' => $user->payment,
					'saveon' => $user->saveon,
					'coop' => $user->coop,
					'deliverymethod' => $user->deliverymethod,
					]);
				$order->cutoffdate()->associate($cutoff);
				$user->orders()->save($order);

				\Mail::send('emails.chargereminder', ['user' => $user, 'order' => $order], function($message) use ($user, $order){
					$message->subject('Grocery cards next week - you\'ll be charged Monday');
					$message->to($user->email, $user->name);
				});
			}
			return "orders generated for " . $date;
		}
		return "orders already generated for this date";
	}
}