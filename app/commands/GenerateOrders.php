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

				//calculate order profits - maybe this goes in a separate command?  might not have the profit per store at order generation time
				$profit = ($user->coop * 9) + ($user->saveon * 7.8); //TODO profit per store should be pulled from the cutoff
				if($user->payment)
				{
					$profit -= (($user->saveon + $user->coop) / 2.9);
					$profit -= 0.30;
				}
				$order->profit = $profit;

				$supp = $user->classesSupported();
				$buckets = count($supp);
				if($buckets > 0)
				{
					$perBucket = $profit / $buckets;
					$splits = GenerateOrders::splits();
					foreach($supp as $class)
					{
						$order->{$class} = $perBucket * $splits[$class]['class'];
						$order->pac += $perBucket * $splits[$class]['pac'];
						$order->tuitionreduction += $perBucket * $splits[$class]['tuitionreduction'];
					}
				}
				else
				{
					$order->pac = $profit * 0.25;
					$order->tuitionreduction = $profit * 0.75;
				}
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

	public static function splits()
	{
		return [
			'marigold' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'daisy' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'sunflower' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'bluebell' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'class_1' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'class_2' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'class_3' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'class_4' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'class_5' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'class_6' => ['class' => 0.6, 'pac' => 0.05, 'tuitionreduction' => 0.35],
			'class_7' => ['class' => 0.7, 'pac' => 0.05, 'tuitionreduction' => 0.25],
			'class_8' => ['class' => 0.8, 'pac' => 0.05, 'tuitionreduction' => 0.15],
		];
	}

}
