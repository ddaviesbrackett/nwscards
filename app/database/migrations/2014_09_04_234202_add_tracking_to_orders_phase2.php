<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrackingToOrdersPhase2 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orders', function(Blueprint $table)
		{
			$table->decimal('marigold', 6, 2);
			$table->decimal('daisy', 6, 2);
			$table->decimal('sunflower', 6, 2);
			$table->decimal('bluebell', 6, 2);
			$table->decimal('class_1', 6, 2);
			$table->decimal('class_2', 6, 2);
			$table->decimal('class_3', 6, 2);
			$table->decimal('class_4', 6, 2);
			$table->decimal('class_5', 6, 2);
			$table->decimal('class_6', 6, 2);
			$table->decimal('class_7', 6, 2);
			$table->decimal('class_8', 6, 2);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('orders', function(Blueprint $table)
		{
			$table->dropColumn('marigold', 'daisy', 'sunflower', 'bluebell', 'class_1', 'class_2', 'class_3', 'class_4', 'class_5', 'class_6', 'class_7', 'class_8');
		});
	}

}
