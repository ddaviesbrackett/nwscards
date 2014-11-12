<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnetimeOrderColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
		{
		    $table->int('coop_onetime');
		    $table->int('saveon_onetime');
		    $table->int('schedule_onetime');
		});

		Schema::table('orders', function($table)
		{
		    $table->int('coop_onetime');
		    $table->int('saveon_onetime');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table)
		{
		    $table->dropColumn('coop_onetime, saveon_onetime, schedule_onetime');
		});

		Schema::table('orders', function($table)
		{
		    $table->dropColumn('coop_onetime, saveon_onetime');
		});
	}
}
