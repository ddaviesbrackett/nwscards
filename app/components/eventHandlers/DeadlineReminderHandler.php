<?php namespace NWSCards\components\eventHandlers;
use \CutoffDate;
class DeadlineReminderHandler {
	public function handle($date) {
		$target = $date->copy()->addDays(2);
		$cutoff = CutoffDate::where('cutoff', '=', $target->format('Y-m-d'))->orderby('cutoff', 'desc')->first();
		if(! isset($cutoff)) {
			return;
		}

		$currentMonthly = $cutoff->first?'monthly':'monthly-second';

		$users = \User::where('stripe_active', '=', 1)
		/*->where(function($q) use ($currentMonthly){
			$q->where('schedule', '=', 'biweekly')
			->orWhere('schedule', '=', $currentMonthly)
			->orWhere('schedule_onetime', '=', $currentMonthly);
		})*/
		->where('no_beg', '<>', 1)
		->get();

		foreach($users as $user)
		{
			\Mail::send('emails.deadlinereminder', ['user' => $user, 'cutoff' => $cutoff], function($message) use ($user){
				$message->subject('STOCK UP FOR SUMMER! Last chance for grocery cards this school year');
				$message->to($user->email, $user->name);
			});
		}

		$usersToBeg = \User::where('stripe_active', '=', 1)
			->where('schedule', '=', 'none')
			->where('schedule_onetime', '=', 'none')
			->where('no_beg', '<>', 1)
			->get();

		foreach($usersToBeg as $user)
		{
			\Mail::send('emails.orderbeg', ['user' => $user, 'cutoff' => $cutoff], function($message) use ($user){
				$message->subject('STOCK UP FOR SUMMER! Last chance for grocery cards this school year');
				$message->to($user->email, $user->name);
			});
		}

		return "reminder emails sent for " . $date;

	}
}