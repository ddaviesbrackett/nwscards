<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AssignAdminRights extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'assignadmin';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Give the specified user account administrator rights.';

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
		$group = Sentry::findGroupByName('Administrator');
		$user = Sentry::findUserByLogin($this->argument('user'));
		if(! $user->addGroup($group)) {
			throw new Exception("could not add user to group");
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
			array('user', InputArgument::REQUIRED, 'User to administrify'),
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
