<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PerOrderProfitNumbers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cutoffdates', function($table)
		{
		    $table->decimal('saveon_cheque_value', 10, 2);
		    $table->decimal('saveon_card_value', 10, 2);
		    $table->decimal('coop_cheque_value', 10, 2);
		    $table->decimal('coop_card_value', 10, 2);
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
		    $table->dropColumn('saveon_cheque_value', 'saveon_card_value', 'coop_cheque_value', 'coop_card_value');
		});
	}

}
