<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public static function getFormattedDates() {
		return array_map(function(array $dts){
			return array_map(function(DateTime $d){
				return $d->format('l, F jS'); //yay php
			}, $dts);
		}, BaseController::getDates());
	}

	public static function getDates() {
		$cutoffs = BaseController::getCutoffs();
		return [
			'charge' => BaseController::changeDates('P6D', $cutoffs),
			'delivery' => BaseController::changeDates('P8D', $cutoffs),
		];
	}

	private static function changeDates($interval, array $dates)
	{
		foreach($dates as $k => $v) {
			$date = new DateTime($v, new DateTimeZone('America/Los_Angeles'));
			$date->add(new DateInterval($interval));
			$dates[$k] = $date;
		}
		return $dates;
	}

	/*
	* cutoff dates are the last day on which we can accept an order; orders are charged 6 days later, and delivered 8 days later (so, 2 days after charge).
	*/
	private static function getCutoffs( $target = NULL ) {;
		if(is_null($target)){
			$target = date('Y-m-d');
		}
		$ret = array();
		$cutoffs = DB::table('cutoffdates')->where('cutoff','>=',$target)->orderBy('cutoff','asc')->take(2)->get();
		$cutoff = $cutoffs[0];
		$ret['biweekly'] = $cutoff->cutoff;
		if($cutoff->monthly) {
			$ret['monthly'] = $cutoff->cutoff;
		}
		else
		{
			$ret['monthly'] = $cutoffs[1]->cutoff;
		}
		return $ret;
	}
}
