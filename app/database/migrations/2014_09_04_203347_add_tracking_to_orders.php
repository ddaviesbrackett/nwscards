<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrackingToOrders extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orders', function(Blueprint $table)
		{
			$table->decimal('pac',6,2);
			$table->decimal('tuitionreduction',6,2);
			$table->decimal('profit',6,2);
			$table->dropColumn('marigold', 'daisy', 'sunflower', 'bluebell', 'class_1', 'class_2', 'class_3', 'class_4', 'class_5', 'class_6', 'class_7', 'class_8');
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
			$table->dropColumn('pac', 'tuitionreduction');
		});
	}

}
