<?php namespace NWSCards\eventHandlers;
use \CutoffDate;
class PickupReminderHandler {
	public function handle($date) {
		$target = $date->copy()->subDays(5);
		$cutoff = \CutoffDate::where('cutoff', '=', $target->format('Y-m-d'))->orderby('cutoff', 'desc')->first();
		if(! isset($cutoff)) {
			return;
		}

		foreach($cutoff->orders as $order)
		{
			$user = $order->user;
			if(!$user->deliverymethod)
			{
				\Mail::send('emails.pickupreminder', ['user' => $user, 'order' => $order], function($message) use ($user){
					$message->subject('Remember to pick up your grocery cards Wednesday');
					$message->to($user->email, $user->name);
				});
			}
		}
		return "pickup reminders sent for " . $date;
	}
}