<?php namespace NWSCards\commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AugustReminder extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'augustreminder';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Email the entire user base to get them to resume their summer-suspended order';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$users = \User::where('no_beg', '<>', 1)->where('schedule', '=', 'none')->get();
		foreach($users as $user)
		{			
			\Mail::send('emails.special-september-resume', ['user' => $user], function($message) use ($user){
				$message->subject('The Grocery Card Fairies are ready for your order! Please resume before September 1!');
				$message->to($user->email, $user->name);
			});
			$this->info("mail sent to ".$user->email);
		}
		$this->info("special august pickup reminders sent to ".$users->count()." users.");
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

}
