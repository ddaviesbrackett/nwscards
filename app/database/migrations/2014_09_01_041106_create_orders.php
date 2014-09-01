<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrders extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function($table){
			$table->increments('id');
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('cutoff_date_id');

			$table->boolean('paid');
			
			$table->tinyInteger('payment'); //0 debit, 1 credit
			$table->integer('saveon');
			$table->integer('coop');
			$table->tinyInteger('deliverymethod'); //0 pickup, 1 mail

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

			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('cutoff_date_id')->references('id')->on('cutoffdates');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}

}
