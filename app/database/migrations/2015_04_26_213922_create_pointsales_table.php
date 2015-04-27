<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pointsales', function(Blueprint $table)
		{
			$table->increments('id');

			$table->tinyInteger('payment'); //0 debit, 1 credit
			$table->integer('saveon_dollars');
			$table->integer('coop_dollars');
			$table->decimal('profit', 6,2);
			
			$table->boolean('paid');
			$table->timestamp('saledate');

			$table->timestamps();
		});

		Schema::create('classes_pointsales', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('pointsale_id');
			$table->unsignedInteger('class_id');
			$table->decimal('profit',6,2);


			$table->foreign('class_id')->references('id')->on('classes');
			$table->foreign('pointsale_id')->references('id')->on('pointsales');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('classes_pointsales');
		Schema::drop('pointsales');
	}

}
