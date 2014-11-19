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
		    $table->integer('coop_onetime')->nullable();
		    $table->integer('saveon_onetime')->nullable();
		    $table->string('schedule_onetime')->nullable();
		});

		Schema::table('orders', function($table)
		{
		    $table->integer('coop_onetime')->nullable();
		    $table->string('saveon_onetime')->nullable();
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
		    $table->dropColumn('coop_onetime', 'saveon_onetime', 'schedule_onetime');
		});

		Schema::table('orders', function($table)
		{
		    $table->dropColumn('coop_onetime', 'saveon_onetime');
		});
	}
}
