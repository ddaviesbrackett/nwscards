<?php namespace NWSCards\components\eventHandlers;
use \CutoffDate;
class SpecialMarchHandler {
	public function handle() {

		foreach(User::where('nobeg', '<>', 1)->where('schedule', '=', 'none') as $user)
		{
			$user = $order->user;
			if(!$user->deliverymethod)
			{
				\Mail::send('emails.special-september-resume', ['user' => $user, 'order' => $order], function($message) use ($user){
					$message->subject('The Grocery Card Fairies are ready for your order!');
					$message->to($user->email, $user->name);
				});
			}
		}
		return "special march pickup reminders sent";
	}
}