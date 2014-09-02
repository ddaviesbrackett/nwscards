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

	public static function getDates() {
		$cutoffs = BaseController::getCutoffs();
		return [
			'charge' => BaseController::formatCutoffs('P6D', $cutoffs),
			'delivery' => BaseController::formatCutoffs('P8D', $cutoffs),
		];
	}

	private static function formatCutoffs($interval, array $cutoffDates)
	{
		foreach($cutoffDates as $k => $v) {
			$date = new DateTime($v);
			$date->add(new DateInterval($interval));
			$cutoffDates[$k] = $date->format('l, F jS');
		}
		return $cutoffDates;
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
