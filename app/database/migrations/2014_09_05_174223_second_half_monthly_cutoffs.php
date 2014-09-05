<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SecondHalfMonthlyCutoffs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cutoffdates', function($table)
		{
		    $table->renameColumn('monthly', 'first');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cutoffdates', function($table)
		{
		    $table->renameColumn('first', 'monthly');
		});
	}

}
