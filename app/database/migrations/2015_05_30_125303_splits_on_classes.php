<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SplitsOnClasses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('classes', function(Blueprint $table)
		{
			$table->decimal('classsplit', 6,2);
			$table->decimal('pacsplit', 6,2);
			$table->decimal('tuitionsplit', 6,2);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$table->dropColumn('classsplit', 6,2);
		$table->dropColumn('pacsplit', 6,2);
		$table->dropColumn('tuitionsplit', 6,2);
	}

}
