<?php

class Pointsale extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pointsales';
	protected $dates = ['created_at', 'updated_at', 'saledate'];

	protected $fillable = [
		'payment',
		'saveon_dollars',
		'coop_dollars',
		'paid',
		'saledate',
	];

	public function schoolclasses() {
		return $this->belongsToMany('SchoolClass', 'classes_pointsales', 'pointsale_id', 'class_id')->withPivot('profit');
	}

	public function isCreditcard() {
		return $this->payment;
	}

	public function newCollection(array $models = [])
	{
	    return new Pointsales($models);
	}
}
