<?php namespace NWSCards\components\eventHandlers;
use \CutoffDate;
class SpecialAugustHandler {
	public static function handle() {

		foreach(User::where('nobeg', '<>', 1)->where('schedule', '=', 'none') as $user)
		{			
			SpecialAugustHandler::sendAugustEmail($user);
		}
		return "special march pickup reminders sent";
	}

	public static function sendAugustEmail($user)
	{
		\Mail::send('emails.special-september-resume', ['user' => $user, 'order' => $order], function($message) use ($user){
			$message->subject('The Grocery Card Fairies are ready for your order!');
			$message->to($user->email, $user->name);
		});
	}
}