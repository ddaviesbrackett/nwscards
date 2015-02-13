<?php

class Expense extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'expenses';

	protected $fillable = [
		'expense_date',
		'amount',
		'description',
		'class_id',
	];

	public function schoolclass() {
		return $this->belongsTo('SchoolClass', 'class_id');
	}

	public function getDates()
	{
	    return ['expense_date', 'updated_at', 'created_at'];
	}
}
