<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PopulateDependentCutoffDates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cutoffdates', function(Blueprint $table)
		{
			DB::update('update cutoffdates set delivery = DATE_ADD(cutoff, INTERVAL ? DAY) where id < 10000', [7]);
			DB::update('update cutoffdates set charge = DATE_ADD(cutoff, INTERVAL ? DAY) where id < 10000', [5]);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cutoffdates', function(Blueprint $table)
		{
			//
		});
	}

}
