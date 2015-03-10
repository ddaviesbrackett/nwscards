<?php namespace NWSCards\components\eventHandlers;
use \CutoffDate;
class PickupReminderHandler {
	public function handle($date) {
		$target = $date->copy()->addDays(2);
		$cutoff = \CutoffDate::where('delivery', '=', $target->format('Y-m-d'))->first();
		if(! isset($cutoff)) {
			return;
		}

		foreach($cutoff->orders as $order)
		{
			$user = $order->user;
			if(!$user->deliverymethod)
			{
				\Mail::send('emails.pickupreminder', ['user' => $user, 'order' => $order], function($message) use ($user, $target){
					$message->subject(sprintf('Remember to pick up your grocery cards %s', $target->format('l')));
					$message->to($user->email, $user->name);
				});
			}
		}
		return "pickup reminders sent for " . $date;
	}
}