<?php

class Order extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'orders';

	protected $fillable = [
		'paid',
		'payment',
		'saveon',
		'coop',
		'saveon_onetime',
		'coop_onetime',
		'deliverymethod',
		'marigold',
		'daisy',
		'sunflower',
		'bluebell',
		'class_1',
		'class_2',
		'class_3',
		'class_4',
		'class_5',
		'class_6',
		'class_7',
		'class_8',
	];

	public function user() {
		return $this->belongsTo('User');
	}

	public function cutoffdate() {
		return $this->belongsTo('CutoffDate', 'cutoff_date_id');
	}

	public function schoolclasses() {
		return $this->belongsToMany('SchoolClass', 'classes_orders', 'order_id', 'class_id')->withPivot('profit');
	}

	public function isCreditcard() {
		return $this->payment;
	}

	public function totalCards() {
		return $this->coop + $this->saveon + $this->coop_onetime + $this->saveon_onetime;
	}

	public function hasOnetime() {
		return $this->coop_onetime + $this->saveon_onetime > 0;
	}
}
