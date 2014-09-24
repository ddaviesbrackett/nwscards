<?php

class CutoffDate extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cutoffdates';

	public function orders() {
		return $this->hasMany('Order');
	}

	public function users() {
		return $this->belongsToMany('User', 'orders');
	}

	public function chargedate() {
		return (new \Carbon\Carbon($this->cutoff))->addDays(6);
	}

	public function deliverydate() {
		return (new \Carbon\Carbon($this->cutoff))->addDays(8);	
	}
}
