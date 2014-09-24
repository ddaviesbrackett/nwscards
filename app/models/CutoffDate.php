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

	public function cutoffdate() {
		return (new \Carbon\Carbon($this->cutoff, 'America/Los_Angeles'));
	}
	public function chargedate() {
		return $this->cutoffdate()->addDays(6);
	}

	public function deliverydate() {
		return $this->cutoffdate()->addDays(8);	
	}
}
