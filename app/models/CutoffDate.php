<?php

class CutoffDate extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cutoffdates';

	protected $fillable = [
		'saveon_cheque_value',
		'saveon_card_value',
		'coop_cheque_value',
		'coop_card_value',
	];

	public function getSaveonChequeValueAttribute($val) {
		return floatval($val);
	}
	public function getSaveonCardValueAttribute($val) {
		return floatval($val);
	}
	public function getCoopChequeValueAttribute($val) {
		return floatval($val);
	}
	public function getCoopCardValueAttribute($val) {
		return floatval($val);
	}

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
		return (new \Carbon\Carbon($this->charge, 'America/Los_Angeles'));
	}

	public function deliverydate() {
		return (new \Carbon\Carbon($this->delivery, 'America/Los_Angeles'));
	}
}
