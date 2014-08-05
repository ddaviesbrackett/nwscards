<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('CutoffDateSeeder');

		$this->command->info('Cutoff dates populated');
	}

}

class CutoffDateSeeder extends Seeder {

	public function run () {
		CutoffDate::create(array('cutoff' =>'2014-09-02', 'monthly'=> true));
		CutoffDate::create(array('cutoff' =>'2014-09-16', 'monthly'=> false));
		CutoffDate::create(array('cutoff' =>'2014-09-30', 'monthly'=> true));
		CutoffDate::create(array('cutoff' =>'2014-10-14', 'monthly'=> false));
		CutoffDate::create(array('cutoff' =>'2014-10-28', 'monthly'=> true));
		CutoffDate::create(array('cutoff' =>'2014-11-11', 'monthly'=> false));
		CutoffDate::create(array('cutoff' =>'2014-11-25', 'monthly'=> true));
		CutoffDate::create(array('cutoff' =>'2014-12-09', 'monthly'=> false));
		CutoffDate::create(array('cutoff' =>'2015-01-06', 'monthly'=> true));
		CutoffDate::create(array('cutoff' =>'2015-01-20', 'monthly'=> false));
		CutoffDate::create(array('cutoff' =>'2015-02-03', 'monthly'=> true));
		CutoffDate::create(array('cutoff' =>'2015-02-17', 'monthly'=> false));
		CutoffDate::create(array('cutoff' =>'2015-03-03', 'monthly'=> true));
		CutoffDate::create(array('cutoff' =>'2015-03-17', 'monthly'=> false));
		CutoffDate::create(array('cutoff' =>'2015-03-31', 'monthly'=> true));
		CutoffDate::create(array('cutoff' =>'2015-04-14', 'monthly'=> false));
		CutoffDate::create(array('cutoff' =>'2015-04-28', 'monthly'=> true));
		CutoffDate::create(array('cutoff' =>'2015-05-12', 'monthly'=> false));
		CutoffDate::create(array('cutoff' =>'2015-05-26', 'monthly'=> true));
	}
}
