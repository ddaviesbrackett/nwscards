<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class EmailReminder extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'orders:pickupRemind';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'remind people they have orders to pick up.';

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
		$target = $this->argument('targetDate');
		if(is_null($target)) {
			$target = \Carbon\Carbon::now('America/Los_Angeles')->addDays(-6)->format('Y-m-d');
		}

		$cutoff = CutoffDate::where('cutoff', '=', $target)->with('orders.user')->firstOrFail();
		
		foreach($cutoff->orders as $order)
		{
			$user = $order->user;
			if(!$user->deliverymethod)
			{
				Mail::send('emails.pickupreminder', ['user' => $user, 'order' => $order], function($message) use ($user){
					$message->subject('Grocery cards pick-up tomorrow');
					$message->to($user->email, $user->name);
				});
			}
		}
	}


	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
					array('targetDate', InputArgument::OPTIONAL, 'The (optional) date to generate emails for. Assumes today if not specified.'),
				);
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
