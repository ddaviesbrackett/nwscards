<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;

class NightlyProcessing extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'nightly-processing';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Runs the periodic actions required for a particular night';

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
		$date = Carbon::parse($this->argument('date'));
		
		$eventResults = array_where(Event::fire('timed.nightly', [$date]), function($k, $v) {
			return !is_null($v);
		});
		if(count($eventResults) > 0){
			if (! empty($_ENV['error_to_address'])) {
				Mail::send('emails.nightly', ['model' => $eventResults], function($message) use ($date){
					$message->subject('nightly processing: '.$date);
					$message->to($_ENV['error_to_address'], 'Error Person');
					$message->from('noreply@grocerycards.nelsonwaldorf.org', $_ENV['error_from_name']);
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
			array('date', InputArgument::OPTIONAL, 'the date (YYYY-MM-DD) for which commands are to be run', 'now'),
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
