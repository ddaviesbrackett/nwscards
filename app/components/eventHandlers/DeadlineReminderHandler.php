<?php namespace NWSCards\eventHandlers;
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
		->where(function($q) use ($currentMonthly){
			$q->where('schedule', '=', 'biweekly')->orWhere('schedule', '=', $currentMonthly);
		})
		->get();

		foreach($users as $user)
		{
			\Mail::send('emails.deadlinereminder', ['user' => $user, 'cutoff' => $cutoff], function($message) use ($user){
				$message->subject('Need to change your grocery card order? Deadline is tomorrow at midnight');
				$message->to($user->email, $user->name);
			});
		}

		return "reminder emails sent for " . $date;

	}
}