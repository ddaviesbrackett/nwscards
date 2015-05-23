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

	public function pointsales() {
		return $this->belongsToMany('Pointsale', 'classes_pointsales', 'class_id', 'pointsale_id')->withPivot('profit');
	}

	public function orders() {
		return $this->belongsToMany('Order', 'classes_orders', 'class_id', 'order_id')->withPivot('profit');
	}

	public function users() {
		return $this->belongsToMany('users', 'classes_users', 'class_id', 'pointsale_id');
	}
}
