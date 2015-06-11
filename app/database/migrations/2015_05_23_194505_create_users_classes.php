<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersClasses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('classes_users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('class_id');

			$table->foreign('class_id')->references('id')->on('classes');
			$table->foreign('user_id')->references('id')->on('users');
		});

		Schema::create('classes_orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('order_id');
			$table->unsignedInteger('class_id');
			$table->decimal('profit',6,2);


			$table->foreign('class_id')->references('id')->on('classes');
			$table->foreign('order_id')->references('id')->on('orders');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('classes_users');
		Schema::drop('classes_orders');
	}

}
