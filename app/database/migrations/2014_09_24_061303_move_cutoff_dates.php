<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveCutoffDates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::update('update cutoffdates set cutoff = DATE_ADD(cutoff, INTERVAL ? DAY) where id < 10000', [1]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::update('update cutoffdates set cutoff = DATE_ADD(cutoff, INTERVAL ? DAY) where id < 10000', [-1]);
	}

}
