<?php

class SchoolClass extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'classes';

	protected $fillable = [
		'name',
		'bucketname',
	];

	public function expenses() {
		return $this->hasMany('Expense', 'class_id');
	}
}
