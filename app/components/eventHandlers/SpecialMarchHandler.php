<?php namespace NWSCards\components\eventHandlers;
use \CutoffDate;
class SpecialMarchHandler {
	public function handle() {
		$cutoff = \CutoffDate::where('delivery', '=', '2015-03-25')->first();
		if(! isset($cutoff)) {
			return 'error sending special march pickup reminders';
		}

		foreach($cutoff->orders as $order)
		{
			$user = $order->user;
			if(!$user->deliverymethod)
			{
				\Mail::send('emails.special-march-pickupreminder', ['user' => $user, 'order' => $order], function($message) use ($user){
					$message->subject('PICKUP DATE CHANGE: grocery card pickup Monday March 30');
					$message->to($user->email, $user->name);
				});
			}
		}
		return "special march pickup reminders sent";
	}
}