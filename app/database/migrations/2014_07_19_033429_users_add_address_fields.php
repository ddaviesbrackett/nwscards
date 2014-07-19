<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersAddAddressFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table){
			$table->string('address1');
			$table->string('address2');
			$table->string('city');
			$table->string('province');
			$table->string('postal_code');
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
			$table->dropColumn('address1');
			$table->dropColumn('address2');
			$table->dropColumn('city');
			$table->dropColumn('province');
			$table->dropColumn('postal_code');
		});
	}

}
