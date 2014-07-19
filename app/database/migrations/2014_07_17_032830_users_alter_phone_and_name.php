<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersAlterPhoneAndName extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table){
			$table->renameColumn('first_name', 'name');
			$table->renameColumn('last_name', 'phone');
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
			$table->renameColumn('name', 'first_name');
			$table->renameColumn('phone', 'last_name');
		});
	}

}
