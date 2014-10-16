<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateOrders extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'orders:generate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate orders whose cutoff dates have passed.';

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
			$target = date('Y-m-d');
		}

		$cutoff = CutoffDate::where('cutoff', '=', $target)->orderby('cutoff', 'desc')->firstOrFail();
		$currentMonthly = $cutoff->first?'monthly':'monthly-second';

		if($cutoff->orders->isEmpty()){ //don't regenerate orders that have been generated already
			$users = User::where('stripe_active', '=', 1)
			->where(function($q){
				$q->where('saveon', '>', '0')->orWhere('coop','>','0');
			})
			->where(function($q) use ($currentMonthly){
				$q->where('schedule', '=', 'biweekly')->orWhere('schedule', '=', $currentMonthly);
			})
			->get();

			foreach($users as $user)
			{
				$order = new Order([
					'paid' => 0,
					'payment' => $user->payment,
					'saveon' => $user->saveon,
					'coop' => $user->coop,
					'deliverymethod' => $user->deliverymethod,
					]);
				$order->cutoffdate()->associate($cutoff);
				$user->orders()->save($order);

				Mail::send('emails.chargereminder', ['user' => $user, 'order' => $order], function($message) use ($user, $order){
					$message->subject('Grocery cards next week - you\'ll be charged Monday');
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
					array('targetDate', InputArgument::OPTIONAL, 'The (optional) date to generate orders for. Assumes today if not specified.'),
				);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];/*array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);*/
	}
}
