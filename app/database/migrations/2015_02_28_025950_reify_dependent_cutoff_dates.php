<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReifyDependentCutoffDates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cutoffdates', function(Blueprint $table)
		{
			$table->timestamp('delivery');
			$table->timestamp('charge');
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
			$table->dropColumn('delivery');
			$table->dropColumn('charge');
		});
	}

}
