<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeSentryAdminGroup extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the group
	    $group = Sentry::createGroup(array(
	        'name'        => 'Administrator',
	        'permissions' => array(
	            'admin' => 1,
	            'users' => 1,
	        ),
	    ));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$group = Sentry::findGroupByName('admin');
		$group->delete();
	}

}
