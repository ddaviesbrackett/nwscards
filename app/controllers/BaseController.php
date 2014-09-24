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

	protected function dumpLastQuery() {
		$queries = DB::getQueryLog();
		$last_query = end($queries);
		var_dump($last_query);
	}

	public static function getFormattedDates() {
		return array_map(function(array $dts){
			return array_map(function($d){
				return $d->format('l, F jS');
			}, $dts);
		}, BaseController::getCutoffs());
	}

	/*
	* cutoff dates are the last day on which we can accept an order; orders are charged 6 days later, and delivered 8 days later (so, 2 days after charge).
	*/
	private static function getCutoffs( $target = NULL ) {;
		if(is_null($target)){
			$target = date('Y-m-d');
		}
		$ret = array();
		$cutoffs = CutoffDate::where('cutoff','>=',$target)->orderBy('cutoff','asc')->take(2)->get();
		$cutoff = $cutoffs[0];
		$ret['biweekly'] = ['cutoff' => $cutoff->cutoffdate(), 'charge' => $cutoff->chargedate(), 'delivery' => $cutoff->deliverydate()];
		if($cutoff->first) {
			$ret['monthly-second'] = ['cutoff' => $cutoffs[1]->cutoffdate(), 'charge' => $cutoffs[1]->chargedate(), 'delivery' =>  $cutoffs[1]->deliverydate()];
			$ret['monthly'] = ['cutoff' => $cutoff->cutoffdate(), 'charge' => $cutoff->chargedate(), 'delivery' =>  $cutoff->deliverydate()];
		}
		else
		{
			$ret['monthly-second'] = ['cutoff' => $cutoff->cutoffdate(), 'charge' => $cutoff->chargedate(), 'delivery' =>  $cutoff->deliverydate()];
			$ret['monthly'] = ['cutoff' => $cutoffs[1]->cutoffdate(), 'charge' => $cutoffs[1]->chargedate(), 'delivery' =>  $cutoffs[1]->deliverydate()];
		}
		return $ret;
	}
}
