<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersAddClassFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table){
			$table->boolean('marigold');
			$table->boolean('daisy');
			$table->boolean('sunflower');
			$table->boolean('bluebell');
			$table->boolean('class_1');
			$table->boolean('class_2');
			$table->boolean('class_3');
			$table->boolean('class_4');
			$table->boolean('class_5');
			$table->boolean('class_6');
			$table->boolean('class_7');
			$table->boolean('class_8');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table){
			$table->dropColumn('marigold');
			$table->dropColumn('daisy');
			$table->dropColumn('sunflower');
			$table->dropColumn('bluebell');
			$table->dropColumn('class_1');
			$table->dropColumn('class_2');
			$table->dropColumn('class_3');
			$table->dropColumn('class_4');
			$table->dropColumn('class_5');
			$table->dropColumn('class_6');
			$table->dropColumn('class_7');
			$table->dropColumn('class_8');
		});
	}

}
