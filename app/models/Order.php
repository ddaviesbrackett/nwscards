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

	public function isCreditcard() {
		return $this->payment;
	}

	public function classesSupported() {
		$ret = [];
		if($this->marigold > 0) $ret[] = 'marigold';
		if($this->daisy > 0) $ret[] = 'daisy';
		if($this->sunflower > 0) $ret[] = 'sunflower';
		if($this->bluebell > 0) $ret[] = 'bluebell';
		if($this->class_1 > 0) $ret[] = 'class_1';
		if($this->class_2 > 0) $ret[] = 'class_2';
		if($this->class_3 > 0) $ret[] = 'class_3';
		if($this->class_4 > 0) $ret[] = 'class_4';
		if($this->class_5 > 0) $ret[] = 'class_5';
		if($this->class_6 > 0) $ret[] = 'class_6';
		if($this->class_7 > 0) $ret[] = 'class_7';
	 	if($this->class_8 > 0) $ret[] = 'class_8';

	 	return $ret;
	}
}
