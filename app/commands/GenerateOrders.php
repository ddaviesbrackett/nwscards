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
		if($cutoff->orders->isEmpty()){
			//today's the day we make orders
			$userquery = User::where('stripe_active', '=', 1)->where(function($q){
				$q->where('saveon', '>', '0')->orWhere('coop','>','0');
			});
			if( ! $cutoff->monthly) {
				$userquery->where('schedule', '=', 'biweekly');
			}
			$users = $userquery->get();
			foreach($users as $user)
			{
				$order = new Order([
					'paid' => 0,
					'payment' => $user->payment,
					'saveon' => $user->saveon,
					'coop' => $user->coop,
					'deliverymethod' => $user->deliverymethod,
					'marigold' => $user->marigold,
					'daisy' => $user->daisy,
					'sunflower' => $user->sunflower,
					'bluebell' => $user->bluebell,
					'class_1' => $user->class_1,
					'class_2' => $user->class_2,
					'class_3' => $user->class_3,
					'class_4' => $user->class_4,
					'class_5' => $user->class_5,
					'class_6' => $user->class_6,
					'class_7' => $user->class_7,
					'class_8' => $user->class_8,
					]);
				$order->cutoffdate()->associate($cutoff);
				$user->orders()->save($order);
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
